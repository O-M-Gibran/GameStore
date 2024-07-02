const tableRows = document.querySelectorAll("tbody tr");
for (const tableRow of tableRows) {
  tableRow.addEventListener("click", function () {
    location.href = this.dataset.href.replace('storepage.php', 'game.php');
  });
}
    document.addEventListener("DOMContentLoaded", function() {
      const rows = document.querySelectorAll('.hasil-tabel');
      rows.forEach(function(row) {
        row.addEventListener('click', function() {
          window.location.href = this.getAttribute('data-href');
        });
      });
    });