document.getElementById("item_code_add")
    .addEventListener("change", function () {
        // إظهار قسم الوحدات
        document.getElementById("unit_div").style.display = "block";
        // إظهار الكمية المستلمة
        document.getElementById("delivery_quantity_div").style.display =
            "block";
        // اضهار السعر
        document.getElementById("price_add_div").style.display = "block";
        // اضهار الاجمالي
        document.getElementById("total_add_div").style.display = "block";

        let option = this.options[this.selectedIndex];

        let main = option.dataset.main;
        let mainName = option.dataset.mainName;

        let retail = option.dataset.retail;
        let retailName = option.dataset.retailName;
        let hasRetail = option.dataset.hasRetail; //يقرى  data-hasRetail

        let unit = document.getElementById("unit_data");

        unit.innerHTML = `<option value="">اختر الوحدة</option>`;

        unit.innerHTML += `<option value="${main}">${mainName}(وحده الاب)</option>`;
        console.log(main);
        console.log(unit.innerHTML);

        if (hasRetail == 1) {
            unit.innerHTML += `<option value="${retail}">${retailName}(وحده تجزئه)</option>`;
        }

        // اذا كان الصنف استهلاكي يضهر تاريخ الانتاج والاانتهاء
        let itemType = option.dataset.type; //يقرى  data-type

        if (itemType == 2) {
            document.getElementById("production_date_div").style.display =
                "block";
            document.getElementById("expir_date_div").style.display = "block";
        } else {
            document.getElementById("production_date_div").style.display =
                "none";
            document.getElementById("expir_date_div").style.display = "none";
        }
    });

// حساب الإجمالي
function calculateTotal() {
    let qty =
        parseFloat(document.getElementById("delivery_quantity").value) || 0;
    let price = parseFloat(document.getElementById("price_add").value) || 0;

    let total = qty * price;

    document.getElementById("total_add").value = total.toFixed();
}

document
    .getElementById("delivery_quantity")
    .addEventListener("input", calculateTotal);
document.getElementById("price_add").addEventListener("input", calculateTotal);

// زر إضافة الصنف
document.getElementById("AddTobill").addEventListener("submit", function (e) {
    let item = document.getElementById("item_code_add").value;
    let unitdata = document.getElementById("unit_data").value;
    let qty = document.getElementById("delivery_quantity").value;
    let price = document.getElementById("price_add").value;
    let productiondate = document.getElementById("production_date").value;
    let expirydate = document.getElementById("expir_date").value;

    // اذا كان الصنف استهلاكي يلزم ادخال تاريخ الاانتاج والاانتهااء
    let itemSelect = document.getElementById("item_code_add");
    let option = itemSelect.options[itemSelect.selectedIndex];
    let itemType = option.dataset.type;

    if (!item) {
        e.preventDefault(); //تجعل الموديل مازل منتضر الااختيار
        Swal.fire({
            icon: "warning",
            title: "تنبيه",
            text: "من فضلك، يرجى اختيار الصنف.",
            confirmButtonText: "حسناً",
        });
        return;
    }

    if (!unitdata) {
        e.preventDefault();
        // alert("من فضلك، يرجى اختيار الوحدة.");
        Swal.fire({
            icon: "warning",
            title: "تنبيه",
            text: "من فضلك، يرجى اختيار الوحدة.",
            confirmButtonText: "حسناً",
        });
        return;
    }

    if (!qty || qty == 0) {
        e.preventDefault();
        // alert("من فضلك، يرجى إدخال الكمية.");
        Swal.fire({
            icon: "warning",
            title: "تنبيه",
            text: "من فضلك، يرجى إدخال الكمية.",
            confirmButtonText: "حسناً",
        });
        return;
    }

    if (!price || price == 0) {
        e.preventDefault();
        // alert("من فضلك، يرجى إدخال السعر.");
        Swal.fire({
            icon: "warning",
            title: "تنبيه",
            text: "من فضلك، يرجى إدخال السعر.",
            confirmButtonText: "حسناً",
        });

        return;
    }

    if (itemType == 2) {
        if (!productiondate) {
            e.preventDefault();
            // alert("من فضلك، يرجى إدخال تاريخ الانتاج.");
            Swal.fire({
                icon: "warning",
                title: "تنبيه",
                text: "من فضلك، يرجى إدخال تاريخ الانتاج.",
                confirmButtonText: "حسناً",
            });
            return;
        }

        if (!expirydate) {
            e.preventDefault();
            // alert("من فضلك، يرجى إدخال تاريخ الانتهاء.");
            Swal.fire({
                icon: "warning",
                title: "تنبيه",
                text: "من فضلك، يرجى إدخال تاريخ الانتهاء.",
                confirmButtonText: "حسناً",
            });
            return;
        }

        // تحويل إلى تواريخ للمقارنة
        let prodDate = new Date(productiondate);
        let expDate = new Date(expirydate);
        if (expDate <= prodDate) {
            e.preventDefault();
            // alert("تاريخ الانتهاء يجب أن يكون أكبر من تاريخ الإنتاج.");
            Swal.fire({
                icon: "warning",
                title: "تنبيه",
                text: "تاريخ الانتهاء يجب أن يكون أكبر من تاريخ الإنتاج.",
                confirmButtonText: "حسناً",
            });
            return;
        }
    }
});
