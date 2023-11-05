const addres = (firstRowww) => {

    const rcount = document.querySelector(".inrow:last-child").dataset.index + 1;
    console.log(rcount);
    const nrow = firstRowww.cloneNode(true);
    console.log(nrow);

    nrow.id = `inrow-${rcount}`;
    nrow.dataset.index = rcount;
    nrow.querySelector('.inid').setAttribute('name', `receivers[${rcount}][id]`);
    nrow.querySelector('.inid').value = "";
  
    nrow.querySelector('.remove-inrow-btn').dataset.removeRow = rcount;
    nrow.querySelector('.remove-inrow-btn').addEventListener('click', (e) => { removeIngredientRoww(e) }, false);
    document.querySelector('#ingredients-containerrrrr').appendChild(nrow);
}

const removeIngredientRoww = (e) => {
    e.preventDefault();
    document.querySelector(`#inrow-${e.currentTarget.dataset.removeRow}`).remove();
}

const mainnnnnnnn = () => {
    if (document.querySelector("#addIngredientttt")) {
        const firstRowww = document.querySelector("#inrow-0");
        const addButtonnn = document.querySelector("#addIngredientttt");
        addButtonnn.addEventListener('click', () => { addres(firstRowww), false });

        const removeButtonss = document.querySelectorAll(".remove-inrow-btn");
        removeButtonss.forEach((btn) => {
            btn.addEventListener('click', (e) => { removeIngredientRoww(e) }, false);
        })
    }
}

mainnnnnnnn();
