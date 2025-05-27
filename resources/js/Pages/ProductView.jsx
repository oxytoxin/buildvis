import { usePage, useForm } from "@inertiajs/react";
import { useRef, useState, useEffect } from "react";
import { Canvas, useFrame } from "@react-three/fiber";
import { OrbitControls } from "@react-three/drei";
import { useLoader } from "@react-three/fiber";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader";
import Layout from "../Components/Layouts/Layout";
import cart from "@routes/cart";
import toast from "react-hot-toast";

export default function ProductView() {
    const { product, model } = usePage().props;
    const [activeTab, setActiveTab] = useState('images');
    const [selectedVariation, setSelectedVariation] = useState(product.variations[0] || null);
    const [quantity, setQuantity] = useState(1);
    const gltf = model ? useLoader(GLTFLoader, model.original_url) : null;

    const form = useForm({
        variation_id: selectedVariation?.id,
        quantity: quantity
    });

    // Update form data when variation or quantity changes
    useEffect(() => {
        form.setData({
            variation_id: selectedVariation?.id,
            quantity: quantity
        });
    }, [selectedVariation, quantity]);

    // Update selected variation when product changes
    useEffect(() => {
        if (product.variations?.length > 0) {
            setSelectedVariation(product.variations[0]);
            setQuantity(1); // Reset quantity when variation changes
        }
    }, [product]);

    const handleVariationClick = (variation) => {
        setSelectedVariation(variation);
        setQuantity(1); // Reset quantity when variation changes
    };

    const handleQuantityChange = (e) => {
        const value = parseInt(e.target.value);
        if (value > 0 && value <= selectedVariation.stock_quantity) {
            setQuantity(value);
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        form.post(cart.add.url(), {
            onSuccess: () => {
                toast.success('Added to cart successfully!');
                setQuantity(1);
            },
            onError: (errors) => {
                toast.error(errors.message || 'Failed to add to cart');
            }
        });
    };

    return (
        <Layout>
            <div className="min-h-screen flex flex-col px-4 md:px-8 lg:px-16 py-4 md:py-8">
                <h2 className="text-xl md:text-2xl font-semibold mb-4">View Product</h2>
                <div className="flex flex-col lg:flex-row gap-8 lg:gap-32 flex-1">
                    <div className="w-full lg:w-1/2">
                        {/* Tabs */}
                        <div className="mb-4 border-b border-gray-200">
                            <nav className="flex space-x-8" aria-label="Tabs">
                                <button
                                    onClick={() => setActiveTab('images')}
                                    className={`py-2 md:py-4 px-1 border-b-2 font-medium text-sm ${activeTab === 'images'
                                        ? 'border-teal-500 text-teal-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                        }`}
                                >
                                    Images
                                </button>
                                <button
                                    onClick={() => setActiveTab('3d')}
                                    className={`py-2 md:py-4 px-1 border-b-2 font-medium text-sm ${activeTab === '3d'
                                        ? 'border-teal-500 text-teal-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                        }`}
                                >
                                    3D Model
                                </button>
                            </nav>
                        </div>

                        {/* Tab Content */}
                        <div className="h-[300px] md:h-[400px] lg:h-[500px] border-2 border-black">
                            {activeTab === '3d' ? (
                                <Canvas>
                                    <color attach="background" args={["#f5efe6"]} />
                                    <ambientLight intensity={0.5} color="white" />
                                    {model && <primitive object={gltf.scene} />}
                                    <OrbitControls />
                                </Canvas>
                            ) : (
                                <div className="h-full flex items-center justify-center bg-gray-100">
                                    <img
                                        src={selectedVariation?.featured_image?.url ?? 'https://placehold.co/600x400'}
                                        alt={selectedVariation?.name ?? product.name}
                                        className="max-h-full max-w-full object-contain"
                                    />
                                </div>
                            )}
                        </div>
                        {!model && activeTab === '3d' && (
                            <p className="text-red-600 font-semibold mt-2">
                                No 3D model found for this product
                            </p>
                        )}
                    </div>
                    <div className="w-full lg:w-1/2 py-4 md:py-8 lg:py-16">
                        <h1 className="text-xl md:text-2xl mt-4">{product.name}</h1>
                        <p className="mt-4 text-sm md:text-base">{product.description}</p>
                        <h2 className="text-lg md:text-xl mt-4">{selectedVariation.name}</h2>
                        <p className="mt-4 text-lg md:text-xl font-semibold">
                            P{selectedVariation?.price}/{product.unit}
                        </p>
                        <p className="mt-2 text-gray-600">
                            {selectedVariation?.stock_quantity} in stock
                        </p>

                        {/* Add to Cart Section */}
                        <div className="mt-8 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <div className="flex items-center gap-2">
                                <label htmlFor="quantity" className="text-sm font-medium text-gray-700 whitespace-nowrap">
                                    Quantity
                                </label>
                                <div className="flex items-center border rounded-md">
                                    <button
                                        type="button"
                                        onClick={() => quantity > 1 && setQuantity(quantity - 1)}
                                        className="px-3 py-1 text-gray-600 hover:bg-gray-100 border-r disabled:opacity-50 disabled:cursor-not-allowed"
                                        disabled={quantity <= 1}
                                    >
                                        -
                                    </button>
                                    <input
                                        type="number"
                                        id="quantity"
                                        min="1"
                                        max={selectedVariation?.stock_quantity}
                                        value={quantity}
                                        onChange={handleQuantityChange}
                                        className="w-16 text-center border-0 focus:ring-0 focus:outline-none"
                                    />
                                    <button
                                        type="button"
                                        onClick={() => quantity < selectedVariation?.stock_quantity && setQuantity(quantity + 1)}
                                        className="px-3 py-1 text-gray-600 hover:bg-gray-100 border-l disabled:opacity-50 disabled:cursor-not-allowed"
                                        disabled={quantity >= selectedVariation?.stock_quantity}
                                    >
                                        +
                                    </button>
                                </div>
                            </div>

                            <form onSubmit={handleSubmit} className="flex-1 sm:flex-none">
                                <button
                                    type="submit"
                                    disabled={!selectedVariation || selectedVariation.stock_quantity === 0 || form.processing}
                                    className={`w-full px-6 py-2 rounded-lg font-medium text-white transition-colors
                                        ${selectedVariation?.stock_quantity > 0
                                            ? 'bg-teal-600 hover:bg-teal-700 disabled:opacity-50'
                                            : 'bg-gray-400 cursor-not-allowed'}`}
                                >
                                    {form.processing
                                        ? 'Adding...'
                                        : selectedVariation?.stock_quantity > 0
                                            ? 'Add to Cart'
                                            : 'Out of Stock'}
                                </button>
                            </form>
                        </div>

                        {/* Product Variations Grid */}
                        <div className="mt-8">
                            <h3 className="text-base md:text-lg font-semibold mb-1">{product.name}</h3>
                            <h4 className="text-xs md:text-sm text-gray-600 mb-3">Available Variations</h4>
                            <div className="grid grid-cols-2 sm:grid-cols-3 gap-2 md:gap-3">
                                {product.variations.map((variation) => (
                                    <div
                                        key={variation.id}
                                        onClick={() => handleVariationClick(variation)}
                                        className={`border rounded-lg p-2 cursor-pointer transition-all ${selectedVariation?.id === variation.id
                                            ? 'border-teal-500 shadow-lg'
                                            : 'hover:shadow-md hover:border-gray-300'
                                            }`}
                                    >
                                        <img
                                            src={variation.featured_image?.url ?? 'https://placehold.co/600x400'}
                                            alt={variation.name}
                                            className="w-full h-20 md:h-24 object-cover rounded-lg mb-1"
                                        />
                                        <h4 className="font-medium text-xs md:text-sm truncate">{variation.name}</h4>
                                        <p className="text-teal-600 text-xs md:text-sm">P{variation.price}</p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
