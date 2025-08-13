import {useState} from 'react';
import {StorePageProps} from '../../types/store';
import {Head} from '@inertiajs/react';
import ProductCard from '../../Components/Store/ProductCard';
import Layout from '../../Components/Layouts/Layout';

export default function Index({products, cartData}: StorePageProps) {
    const [selectedCategory, setSelectedCategory] = useState<string | null>(null);
    const [searchQuery, setSearchQuery] = useState('');
    const [selectedVariations, setSelectedVariations] = useState<Record<number, number>>({});

    // Get unique categories
    const categories = Array.from(new Set(products.map(p => p.category.name)));

    // Filter products based on category and search
    const filteredProducts = products.filter(product => {
        const matchesCategory = !selectedCategory || product.category.name === selectedCategory;
        const matchesSearch = product.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
            product.variations.some(v => v.name.toLowerCase().includes(searchQuery.toLowerCase()));
        return matchesCategory && matchesSearch;
    });

    // Handle variation selection
    const handleVariationChange = (productId: number, variationId: number) => {
        setSelectedVariations(prev => ({
            ...prev,
            [productId]: variationId
        }));
    };

    // Handle search and filter changes
    const handleSearch = (query: string) => {
        setSearchQuery(query);
    };

    const handleCategoryChange = (category: string | null) => {
        setSelectedCategory(category);
    };

    return (
        <Layout>
            <Head title="Store"/>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                {/* Header */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900">Store</h1>
                    <p className="mt-2 text-sm text-gray-600">
                        Browse our collection of construction materials and supplies
                    </p>
                </div>

                {/* Search and Filter Section */}
                <div className="mb-8 gap-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                    <div className="flex-1">
                        <input
                            type="text"
                            placeholder="Search products..."
                            className="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                            value={searchQuery}
                            onChange={(e) => handleSearch(e.target.value)}
                        />
                    </div>
                    <select
                        value={selectedCategory || ''}
                        onChange={(e) => handleCategoryChange(e.target.value || null)}
                        className="rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                    >
                        <option value="">All Categories</option>
                        {categories.map((category) => (
                            <option key={category} value={category}>
                                {category}
                            </option>
                        ))}
                    </select>
                </div>

                {/* Products Grid */}
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    {filteredProducts.map((product) => (
                        <ProductCard
                            key={product.id}
                            product={product}
                            selectedVariationId={selectedVariations[product.id]}
                            onVariationChange={handleVariationChange}
                            cartData={cartData}
                        />
                    ))}
                </div>

                {/* No Results */}
                {filteredProducts.length === 0 && (
                    <div className="text-center py-12 bg-white rounded-lg border border-gray-200">
                        <h3 className="text-lg font-medium text-gray-900">No products found</h3>
                        <p className="mt-2 text-sm text-gray-500">
                            Try adjusting your search or filter to find what you're looking for.
                        </p>
                    </div>
                )}
            </div>
        </Layout>
    );
}
