document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const card = button.closest('.card');
            card.remove();
        });
    });
});

const productsSection = document.querySelector('.products');

function createProductCard(title, price, description, imageData, status) {
    const card = document.createElement('div');
    card.classList.add('card');

    const imagePlaceholder = document.createElement('div');
    imagePlaceholder.classList.add('image-placeholder');
    const img = document.createElement('img');
    img.width = 150;
    img.height = 150;
    img.src = imageData || "https://via.placeholder.com/150";
    img.alt = "Image Placeholder";
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
    deleteButton.src = "./svg/delete-outline.svg";
    deleteButton.alt = "Delete Button";
    deleteButton.addEventListener('click', function() {
        const card = deleteButton.closest('.card');
        card.remove();
    });

    card.appendChild(imagePlaceholder);
    card.appendChild(information);
    card.appendChild(deleteButton);

    productsSection.appendChild(card); 
}

// Example usage:
createProductCard(
    'Samsung Galaxy S21 (128 GB) - Black', 
    '56,999', 
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, corporis autem! Exercitationem magnam obcaecati, iusto architecto, veritatis reiciendis suscipit sequi delectus, maxime vitae illo hic!',
    'https://via.placeholder.com/150',
    'Verified' // Status can be 'Verified', 'Pending', etc.
);
