const tableRows = document.querySelectorAll("tbody tr");
for (const tableRow of tableRows) {
  tableRow.addEventListener("click", function () {
    location.href = this.dataset.href.replace('storepage.php', 'game.php');
  });
}