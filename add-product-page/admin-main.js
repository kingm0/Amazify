document.addEventListener('DOMContentLoaded', function() {
    const productsSection = document.querySelector('.products');

    function createProductCard(title, price, description, image, status) {
        const card = document.createElement('div');
        card.classList.add('card');

        const imagePlaceholder = document.createElement('div');
        imagePlaceholder.classList.add('image-placeholder');
        const img = document.createElement('img');
        img.width = 150;
        img.height = 150;
        img.src = image;
        img.alt = 'Image Placeholder';
        imagePlaceholder.appendChild(img);

        const information = document.createElement('div');
        information.classList.add('information');

        const productTitle = document.createElement('h2');
        productTitle.classList.add('product-title');
        productTitle.textContent = title;
        const productPrice = document.createElement('p');
        productPrice.classList.add('product-price');
        productPrice.textContent = `₹ ${price}`;
        const productDescription = document.createElement('p');
        productDescription.classList.add('product-description');
        productDescription.textContent = description;

        const productStatus = document.createElement('p');
        productStatus.classList.add('product-status', `product-${status.toLowerCase()}`);
        productStatus.textContent = status;

        information.appendChild(productTitle);
        information.appendChild(productPrice);
        information.appendChild(productDescription);
        information.appendChild(productStatus);

        const deleteButton = document.createElement('img');
        deleteButton.classList.add('delete-button');
        deleteButton.src = './svg/delete-outline.svg';
        deleteButton.alt = 'Delete Button';
        deleteButton.addEventListener('click', function() {
            card.remove();
        });

        card.appendChild(imagePlaceholder);
        card.appendChild(information);
        card.appendChild(deleteButton);

        productsSection.appendChild(card);
    }

    // Check if there's new product data
    // if (newProduct) {
        createProductCard(newProduct.title, newProduct.price, newProduct.description, newProduct.image, newProduct.status);
    // }
});
<<<<<<< HEAD
=======
document.addEventListener('DOMContentLoaded', function() {
    const productsSection = document.querySelector('.products');

    productsSection.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-button')) {
            const card = event.target.closest('.card');
            const productId = card.getAttribute('data-id');
            
            console.log('Product ID to delete:', productId); // Debugging statement

            // Send request to delete product
            fetch('./delete_product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: productId })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response from server:', data); // Debugging statement
                if (data.success) {
                    card.remove(); // Remove card from the DOM
                } else {
                    alert('Failed to delete product.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    });
});
>>>>>>> 9d47b56 (changed file location)
