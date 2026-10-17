

document.getElementById("accauont_number").addEventListener("change", function () {

    let accountType =
        this.options[this.selectedIndex].getAttribute("data-account-type");

    let movTypeSelect = document.getElementById("mov_type_select");

    let movTypeInput = document.getElementById("mov_type");


    let movTypeId = "";

  // حساب مورد
    if (accountType == "2") {

        movTypeId = "10";

    }
// حساب عميل
    else if (accountType == "3") {

        movTypeId = "5";

    }
      // حساب بنكي

    else if (accountType == "6") {

        movTypeId = "25";

    }

    else if (!accountType) {

        movTypeId = "";

    }
// اي حساب
    else {

        movTypeId = "4";

    }


    // تخزين الرقم الذي سيتم إرساله إلى Controller
    movTypeInput.value = movTypeId;


    // تحديد الحركة تلقائيًا في القائمة
    movTypeSelect.value = movTypeId;

});
document.getElementById("accauont_number").addEventListener("change", function () {

    let selectedOption = this.options[this.selectedIndex];

    let accountBalance = selectedOption.getAttribute("data-balance");

    let balanceBox = document.getElementById("account_balance_box");

    let balanceElement = document.getElementById("account_current_balance");


    // إذا لم يتم اختيار حساب
    if (!this.value) {

        balanceBox.style.display = "none";

        balanceElement.innerText = "0";

        return;
    }


    // إظهار صندوق الرصيد
    balanceBox.style.display = "block";


    // إظهار الرصيد
    balanceElement.innerText =
        Number(accountBalance || 0).toLocaleString();

});
document.getElementById("accauont_number").addEventListener("change", function () {

    let selectedOption = this.options[this.selectedIndex];

    let accountBalance = Number(
        selectedOption.getAttribute("data-balance") || 0
    );

    let statusElement =
        document.getElementById("account_balance_status");


    // مدين
    if (accountBalance > 0) {

        statusElement.innerText = "مدين (عليه)";
        statusElement.className = "text-danger font-weight-bold";

    }

    // دائن
    else if (accountBalance < 0) {

        statusElement.innerText = "دائن (له)";
        statusElement.className = "text-success font-weight-bold";

    }

    // متزن
    else {

        statusElement.innerText = "متزن";
        statusElement.className = "text-secondary font-weight-bold";

    }

});


