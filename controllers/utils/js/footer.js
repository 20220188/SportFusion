const footerHTML = `
  <footer class="footer">
    <p>&copy; 2024 Your Company Name</p>
    <ul>
      <li><a href="#">Link 1</a></li>
      <li><a href="#">Link 2</a></li>
      <li><a href="#">Link 3</a></li>
    </ul>
  </footer>
  
`;

// Create a new element
const footerElement = document.createElement('div');
footerElement.classList.add('footer'); // Add class for styling

// Set the inner HTML of the element
footerElement.innerHTML = footerHTML;

// Append the element to the desired location in your HTML
document.body.appendChild(footerElement);


