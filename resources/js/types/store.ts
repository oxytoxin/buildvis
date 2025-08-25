export interface Category {
    id: number;
    name: string;
    slug: string;
}

export interface ProductVariation {
    id: number;
    name: string;
    price: number;
    sku: string;
    stock_quantity: number;
    is_active: boolean;
}

export interface Product {
    id: number;
    name: string;
    category: Category;
    unit: string;
    variations: ProductVariation[];
}

export interface StorePageProps {
    wire_id: string;
    products: Product[];
    cartData: Record<number, number>; // variation_id => quantity
}
