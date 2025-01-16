function headerNav() {
  const headerBody = document.querySelector('body#header');

  if (headerBody) {
    headerBody.addEventListener('click', () => {
      parent.location.href = '../tomaraoIndex.php';
    });
  }
}

function resetFilter() {
  const resetBtn = document.getElementById('resetBtn');

  resetBtn.addEventListener('click', function () {
    parent.location.reload();
  });
}

// function filterProducts() {
//   document.getElementById('searchForm').onsubmit = function (event) {
//     event.preventDefault();

//     const data = {
//       veg: document.getElementById('veg').checked,
//       fruits: document.getElementById('fruits').checked,
//       beverages: document.getElementById('beverages').checked,
//       search: document.querySelector('#searchForm input[type="text"]').value,
//     };

//     fetch('../server/filter.php', {
//       method: 'POST',
//       headers: { 'Content-Type': 'application/json' },
//       body: JSON.stringify(data),
//     })
//       .then((response) => response.json())
//       .then((products) => {
//         console.log(products);
//       })
//       .catch(console.error);
//   };
// }

document.addEventListener('DOMContentLoaded', () => {
  headerNav();
  resetFilter();
  // filterProducts();
});
