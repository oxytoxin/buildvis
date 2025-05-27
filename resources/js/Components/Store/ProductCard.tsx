import { Product } from '../../types/store';
import { view } from '@routes/product';
import { useState } from 'react';
import axios from 'axios';
import { toast } from 'react-hot-toast';
import { Link, useForm } from '@inertiajs/react';
import { add } from '@actions/App/Http/Controllers/CartController'

interface ProductCardProps {
    product: Product;
    selectedVariationId: number | undefined;
    onVariationChange: (productId: number, variationId: number) => void;
}

export default function ProductCard({ product, selectedVariationId, onVariationChange }: ProductCardProps) {
    const [quantity, setQuantity] = useState(1);
    const [isAddingToCart, setIsAddingToCart] = useState(false);
    const selectedVariation = product.variations.find(v => v.id === selectedVariationId) || product.variations[0];
    const activeVariations = product.variations.filter(v => v.is_active);
    const { post, data, setData } = useForm({
        variation_id: selectedVariation?.id,
        quantity: quantity
    });

    const handleAddToCart = async (e: React.MouseEvent) => {
        e.preventDefault(); // Prevent any parent click events
        if (!selectedVariation) return;

        try {
            setIsAddingToCart(true);
            post(add.url(), {
                onSuccess: () => {
                    toast.success('Product added to cart successfully!');
                    setQuantity(1);
                }
            });
        } catch (error: any) {
            const errorMessage = error.response?.data?.message || 'Failed to add to cart';
            toast.error(errorMessage);
        } finally {
            setIsAddingToCart(false);
        }
    };

    return (
        <div className="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200 h-full flex flex-col">
            <div className="p-4 flex-1 flex justify-between flex-col">
                <div className="mb-3">
                    <span className="px-2 py-1 text-xs font-medium text-teal-700 bg-teal-100 rounded-full whitespace-nowrap flex-shrink-0">
                        {product.category.name}
                    </span>
                    <Link
                        href={view.get(product.id).url}
                        className="text-base font-semibold text-gray-900 line-clamp-2 flex-1 hover:text-teal-600 transition-colors duration-200"
                    >
                        {product.name}
                    </Link>
                </div>

                <div className="space-y-3">
                    {/* Variation Select */}
                    <div>
                        <label htmlFor={`variation-${product.id}`} className="block text-xs font-medium text-gray-700 mb-1">
                            Select Variation
                        </label>
                        <select
                            id={`variation-${product.id}`}
                            value={selectedVariation?.id || ''}
                            onChange={(e) => onVariationChange(product.id, Number(e.target.value))}
                            className="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                        >
                            {activeVariations.map((variation) => (
                                <option
                                    key={variation.id}
                                    value={variation.id}
                                    disabled={!variation.is_active}
                                >
                                    {variation.name} ({product.unit})
                                </option>
                            ))}
                        </select>
                    </div>

                    {/* Quantity Input */}
                    <div>
                        <label htmlFor={`quantity-${product.id}`} className="block text-xs font-medium text-gray-700 mb-1">
                            Quantity
                        </label>
                        <input
                            type="number"
                            id={`quantity-${product.id}`}
                            min="1"
                            max={selectedVariation?.stock_quantity || 1}
                            value={quantity}
                            onChange={(e) => setQuantity(Math.max(1, Math.min(selectedVariation?.stock_quantity || 1, parseInt(e.target.value) || 1)))}
                            className="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                        />
                        <span className="text-xs text-gray-500 mt-1 block">
                            {selectedVariation?.stock_quantity} available in stock
                        </span>
                    </div>

                    {/* Price Display */}
                    <div className="mt-auto">
                        <div>
                            <span className="text-base font-bold text-teal-600">
                                ₱{selectedVariation?.price.toLocaleString()}
                            </span>
                            <span className="text-xs text-gray-500 ml-1">
                                per {product.unit}
                            </span>
                        </div>
                        <span className="text-xs text-gray-500">
                            SKU: {selectedVariation?.sku}
                        </span>
                    </div>

                    {/* Add to Cart Button */}
                    <button
                        onClick={handleAddToCart}
                        disabled={!selectedVariation?.is_active || isAddingToCart || selectedVariation.stock_quantity < 1}
                        className={`w-full mt-2 px-4 py-2 rounded-lg text-sm font-medium text-white 
                            ${selectedVariation?.is_active && selectedVariation.stock_quantity > 0
                                ? 'bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500'
                                : 'bg-gray-300 cursor-not-allowed'
                            } transition-colors duration-200`}
                    >
                        {isAddingToCart ? 'Adding...' : 'Add to Cart'}
                    </button>

                    {/* Stock Status */}
                    {!selectedVariation?.is_active && (
                        <div className="text-xs text-red-600 font-medium">
                            Out of stock
                        </div>
                    )}
                    {selectedVariation?.is_active && selectedVariation.stock_quantity < 1 && (
                        <div className="text-xs text-red-600 font-medium">
                            No stock available
                        </div>
                    )}
                    {selectedVariation?.is_active && selectedVariation.stock_quantity > 0 && selectedVariation.stock_quantity <= 10 && (
                        <div className="text-xs text-amber-600 font-medium">
                            Only {selectedVariation.stock_quantity} left in stock
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
} 