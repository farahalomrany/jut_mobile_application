const addIngredientRow = (firstRow) => {

    const rowsCount = document.querySelector(".ingredients-row:last-child").dataset.index + 1;
    console.log(rowsCount);
    const newRow = firstRow.cloneNode(true);
    console.log(newRow);

    newRow.id = `ingredients-row-${rowsCount}`;
    newRow.dataset.index = rowsCount;
    newRow.querySelector('.ingredients-size').setAttribute('name', `points[${rowsCount}][size]`);
    newRow.querySelector('.ingredients-size').value = "";
    newRow.querySelector('.ingredients-silver').setAttribute('name', `points[${rowsCount}][silver]`);
    newRow.querySelector('.ingredients-silver').value = "";
    newRow.querySelector('.ingredients-gold').setAttribute('name', `points[${rowsCount}][gold]`);
    newRow.querySelector('.ingredients-gold').value = "";
    newRow.querySelector('.ingredients-platinum').setAttribute('name', `points[${rowsCount}][platinum]`);
    newRow.querySelector('.ingredients-platinum').value = "";
    // newRow.querySelector('.ingredients-ingredie').setAttribute('name', `ingredients[${rowsCount}][ingredient]`);
    // newRow.querySelector('.ingredients-ingredie ').value = "";
    newRow.querySelector('.remove-ingredients-row-btn').dataset.removeRow = rowsCount;
    newRow.querySelector('.remove-ingredients-row-btn').addEventListener('click', (e) => { removeIngredientRow(e) }, false);
    document.querySelector('#ingredients-container').appendChild(newRow);
}

const removeIngredientRow = (e) => {
    e.preventDefault();
    document.querySelector(`#ingredients-row-${e.currentTarget.dataset.removeRow}`).remove();
}

const main = () => {
    if (document.querySelector("#addIngredient")) {
        const firstRow = document.querySelector("#ingredients-row-0");
        const addButton = document.querySelector("#addIngredient");
        addButton.addEventListener('click', () => { addIngredientRow(firstRow), false });

        const removeButtons = document.querySelectorAll(".remove-ingredients-row-btn");
        removeButtons.forEach((btn) => {
            btn.addEventListener('click', (e) => { removeIngredientRow(e) }, false);
        })
    }
}

main();
