export async function deleteProduct(cartId: string, productId: string) {
    const response = await fetch('http://localhost:8000/carts/'+cartId+'/product_delete', {
        method: "POST",
        body: JSON.stringify({productId: productId}),
    });
    if (!response.ok) {
        throw new Error('Failed to fetch data');
    }
}