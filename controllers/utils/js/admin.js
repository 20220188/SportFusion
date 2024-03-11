
//Plantilla para el footer del sitio privado
const footerHTML = `
  <footer class="footer">
    <p style="color: white">&copy; SportsFusion</p>
    <ul>
      <li><p  style="color: white">Jafet Melara</p></li>
      <li><p  style="color: white">Dominic Mejía</p></li>
      <li><p  style="color: white">Kevin Roodríguez</p></li>
    </ul>
  </footer>
  
`;

document.querySelector('title').textContent = 'SportFusion - sitio privado';

// Create a new element
const footerElement = document.createElement('div');
footerElement.classList.add('footer'); // Add class for styling

// Set the inner HTML of the element
footerElement.innerHTML = footerHTML;

// Append the element to the desired location in your HTML
document.body.appendChild(footerElement);


