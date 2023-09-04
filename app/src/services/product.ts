export interface ProductData {
    id: string;
    title: string;
    description: string;
    photo: string;
    price: number;
}

export async function getAllProducts(): Promise<ProductData[]> {
    const response = await fetch('http://api:8000/products');
    if (!response.ok) {
        throw new Error('Failed to fetch data');
    }

    return  response.json();
}