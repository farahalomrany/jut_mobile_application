const addIngredientRoww = (firstRoww) => {

    const rowsCountt = document.querySelector(".ingredients-roww:last-child").dataset.index + 1;
    console.log(rowsCountt);
    const newRoww = firstRoww.cloneNode(true);
    console.log(newRoww);

    newRoww.id = `ingredients-roww-${rowsCountt}`;
    newRoww.dataset.index = rowsCountt;
    newRoww.querySelector('.ingredients-amountt').setAttribute('name', `related_products[${rowsCountt}][id]`);
    newRoww.querySelector('.ingredients-amountt').value = "";
  
    newRoww.querySelector('.remove-ingredients-roww-btn').dataset.removeRow = rowsCountt;
    newRoww.querySelector('.remove-ingredients-roww-btn').addEventListener('click', (e) => { removeIngredientRoww(e) }, false);
    document.querySelector('#ingredients-containerr').appendChild(newRoww);
}

const removeIngredientRoww = (e) => {
    e.preventDefault();
    document.querySelector(`#ingredients-roww-${e.currentTarget.dataset.removeRow}`).remove();
}

const main_two = () => {
    if (document.querySelector("#addIngredient_two")) {
        const firstRoww = document.querySelector("#ingredients-roww-0");
        const addButtonn = document.querySelector("#addIngredient_two");
        console.log(firstRoww);
        console.log(addButtonn);
        addButtonn.addEventListener('click', () => { addIngredientRoww(firstRoww), false });

        const removeButtonss = document.querySelectorAll(".remove-ingredients-roww-btn");
        removeButtonss.forEach((btn) => {
            btn.addEventListener('click', (e) => { removeIngredientRoww(e) }, false);
        })
    }
}

main_two();
