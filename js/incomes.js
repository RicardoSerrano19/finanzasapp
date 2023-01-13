const submitBtn = document.querySelector('#submitButton');

submitBtn.addEventListener('click', (ev) => {
    ev.preventDefault();

    const category = document.querySelector("#category").value;
    const amount = document.querySelector("#amount").value;
    const date = document.querySelector("#date").value;

    if(category == '' || amount == '' || date == ''){
        alert("All elements are required")
        return;
    }

    disableButton();
    fetchTransaction(category, amount, date)
        .then(response => response.json())
        .then(data => {
            if(data){
                alert("Ingreso registrado exitosamente");
                location.reload();
                return;
            }
            if('error' in data){
                console.log(data);
            }
        })
});

function fetchTransaction(pCategory, pAmount, pDate){
    return fetch("./includes/controller/TransactionsController.php", {
        method: 'POST',
        body: JSON.stringify({
            category: pCategory,
            amount: pAmount,
            date: pDate,
            action: 'create'
        })
    });
}

function disableButton(){
    submitBtn.disabled = true;
}
fetch("./includes/controller/TransactionsController.php",{
    method: 'POST',
    body: JSON.stringify({
        action: '/findByType',
        type: 1
    })
})
.then(response => response.json())
.then(data => {
    if('error' in data){
        console.log(data);
    }else{
        renderTransactions(data);
    }
})


const convertDate = (date) => {
    const month = date.toLocaleString('default', {month: 'short'});
    return `${date.getDate()} ${month}. ${date.getFullYear()}`;
}

const convertTime = (time) => {
    let strTime = "" + time;
    if(strTime.length == 1){
        strTime = "0"+time;
    }
    return strTime;
}

const createTransaction = (transactions) => {
    const transactionSection = document.querySelector('.transactions');

    let transactionValues = Object.values(transactions);
    for(let groupOfTransactions of transactionValues){
        
        //Creando grupo de transacciones
        const groupTransaction = document.createElement("div")
        groupTransaction.classList.add("transaction");

         //Crear titulo transacciones diarias
        const groupTransactionDate = document.createElement("div");
        groupTransactionDate.classList.add("transaction_date");
        const groupDate = groupOfTransactions[0].transaction.date;
        groupTransactionDate.textContent = convertDate(new Date(groupDate));

        groupTransaction.appendChild(groupTransactionDate);

        for(let transaction of groupOfTransactions){
            let {id, amount, date, category, type} = transaction.transaction;
            const dateParsed = new Date(date);
    
            //Creando tabla transaccion
            const groupTransactionTable = document.createElement("div");
            groupTransactionTable.classList.add("transactions_table");
    
            // Creando el icono
            const groupTransactionTableIcon = document.createElement("div");
            groupTransactionTableIcon.classList.add("transactions_table-icon");
            const groupTransactionTableIconI = document.createElement("i");
            groupTransactionTableIconI.classList.add("fas");
            if(type == 'ingreso'){
                groupTransactionTableIconI.classList.add("fa-wallet", "i");
            }else{
                groupTransactionTableIconI.classList.add("fa-angle-double-down", "e");
            }
            groupTransactionTableIcon.appendChild(groupTransactionTableIconI);
    
            //Creando la informacion
            const groupTransactionTableInfo = document.createElement("div");
            groupTransactionTableInfo.classList.add("transactions_table-info");
    
            const groupTransactionTableReason = document.createElement("p");
            groupTransactionTableReason.classList.add("transactions_table-info-reason");
            groupTransactionTableReason.textContent = category;
    
            const groupTransactionTableTime = document.createElement("p");
            groupTransactionTableTime.classList.add("transactions_table-info-time");
            groupTransactionTableTime.textContent = `${convertTime(dateParsed.getHours())}:${convertTime(dateParsed.getMinutes())}`;
            groupTransactionTableInfo.append(groupTransactionTableReason, groupTransactionTableTime);
    
            //Creando amount
            const splitAmount = amount.split('.');
    
            const groupTransactionTableAmount = document.createElement("div");
            groupTransactionTableAmount.classList.add("transactions_table-amount");
            groupTransactionTableAmount.textContent = `${type == "ingreso" ? "+" : "-"} ${splitAmount[0]}`;
            
            const groupTransactionTableAmountDecimals = document.createElement("sup");
            groupTransactionTableAmountDecimals.textContent = "." + splitAmount[1]
            groupTransactionTableAmount.appendChild(groupTransactionTableAmountDecimals);
    
            //Agregando los 3 elementos a la transactions_table
            groupTransactionTable.append(groupTransactionTableIcon, groupTransactionTableInfo, groupTransactionTableAmount);
            // Agregando fecha y tabla a la transaccion
            groupTransaction.appendChild(groupTransactionTable);
    
        }
        transactionSection.appendChild(groupTransaction);
    }
}

const renderTransactions = (data) => {
    const orderDates = {};
    for(let transaction of data){
        //createTransaction(transaction)
        const {date} = transaction;
        const currentDate = date.substr(0,10);

        if(currentDate in orderDates){
            orderDates[currentDate] = [...orderDates[currentDate], {transaction}]
        }else{
            orderDates[currentDate] = [{transaction}];
        }
    }
    createTransaction(orderDates);
}

