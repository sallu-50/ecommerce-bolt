import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Cart functionality
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const qty = document.querySelector(`#qty-${productId}`)?.value || 1;
            
            addToCart(productId, qty);
        });
    });
    
 function addToCart(productId, qty = 1) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json', // 🔥 এটা যোগ করো
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ qty })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Cart response data:", data);

        if (data.success) {
            updateCartCount(data.count);
            showNotification(data.message, "success");
        } else {
            showNotification(data.message || "Error adding product to cart", "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("Something went wrong! Try again.", "error");
    });
}

    
    function updateCartCount(count) {
        const cartCountElement = document.querySelector('#cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;
            cartCountElement.classList.remove('hidden');
        }
    }
    
    function showNotification(message, type = 'success') {
        console.log(`Showing notification: "${message}" with type "${type}"`);
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white ${type === 'success' ? 'bg-success-500' : 'bg-danger-500'} shadow-lg z-50 animate-fade-in`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
});