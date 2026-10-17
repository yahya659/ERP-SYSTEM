

document.getElementById("accauont_number").addEventListener("change", function () {

    let accountType =
        this.options[this.selectedIndex].getAttribute("data-account-type");

    let movTypeSelect = document.getElementById("mov_type_select");

    let movTypeInput = document.getElementById("mov_type");


    let movTypeId = "";

    // حساب مورد

    if (accountType == "2") {

        movTypeId = "9";

    }
// حساب عميل
    else if (accountType == "3") {

        movTypeId = "6";

    }

    // حساب بنكي
    else if (accountType == "6") {

        movTypeId = "18";

    }

    else if (!accountType) {

        movTypeId = "";

    }

    // اي حساب
    else {

        movTypeId = "3";

    }


    // تخزين الرقم الذي سيتم إرساله إلى Controller
    movTypeInput.value = movTypeId;


    // تحديد الحركة تلقائيًا في القائمة
    movTypeSelect.value = movTypeId;

});
document.getElementById("accauont_number").addEventListener("change", function () {

    let selectedOption = this.options[this.selectedIndex];

    let accountBalance = Number(
        selectedOption.getAttribute("data-balance") || 0
    );

    let balanceBox =
        document.getElementById("account_balance_box");

    let balanceElement =
        document.getElementById("account_current_balance");

    let statusElement =
        document.getElementById("account_balance_status");


    // إذا لم يتم اختيار حساب
    if (!this.value) {

        balanceBox.style.display = "none";

        balanceElement.innerText = "0";

        statusElement.innerText = "-";
        statusElement.className = "";

        return;
    }


    // إظهار صندوق الرصيد
    balanceBox.style.display = "block";


    // عرض الرصيد
    balanceElement.innerText =
        accountBalance.toLocaleString();


    // تحديد حالة الحساب
    if (accountBalance > 0) {

        statusElement.innerText = "مدين (عليه)";
        statusElement.className =
            "text-danger font-weight-bold";

    } else if (accountBalance < 0) {

        statusElement.innerText = "دائن (له)";
        statusElement.className =
            "text-success font-weight-bold";

    } else {

        statusElement.innerText = "متزن";
        statusElement.className =
            "text-secondary font-weight-bold";
    }

});

