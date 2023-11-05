const addIngredientRowww = (firstRoww) => {

    const rowsCounttt = document.querySelector(".ingredients-rowww:last-child").dataset.index + 1;
    console.log(rowsCounttt);
    const newRoww = firstRoww.cloneNode(true);
    console.log(newRoww);

    newRoww.id = `ingredients-rowww-${rowsCounttt}`;
    newRoww.dataset.index = rowsCounttt;
    newRoww.querySelector('.ingredients-idd').setAttribute('name', `distributors[${rowsCounttt}][id]`);
    newRoww.querySelector('.ingredients-idd').value = "";
  
    newRoww.querySelector('.remove-ingredients-rowww-btn').dataset.removeRow = rowsCounttt;
    newRoww.querySelector('.remove-ingredients-rowww-btn').addEventListener('click', (e) => { removeIngredientRoww(e) }, false);
    document.querySelector('#ingredients-containerrr').appendChild(newRoww);
}

const removeIngredientRoww = (e) => {
    e.preventDefault();
    document.querySelector(`#ingredients-rowww-${e.currentTarget.dataset.removeRow}`).remove();
}

const mainnn = () => {
    if (document.querySelector("#addIngredient_three")) {
        const firstRoww = document.querySelector("#ingredients-rowww-0");
        const addButtonnn = document.querySelector("#addIngredient_three");
        addButtonnn.addEventListener('click', () => { addIngredientRowww(firstRoww), false });

        const removeButtonsss = document.querySelectorAll(".remove-ingredients-rowww-btn");
        removeButtonsss.forEach((btn) => {
            btn.addEventListener('click', (e) => { removeIngredientRoww(e) }, false);
        })
    }
}

mainnn();
