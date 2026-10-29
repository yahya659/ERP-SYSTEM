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

const itemSelect = document.getElementById("item_code_add");
const batchSelect = document.getElementById("batch_id");
const batchDiv = document.getElementById("batch_div");
const priceInput = document.getElementById("price_add");
const quantityInput = document.getElementById("delivery_quantity");

// رقم الفاتورة الموجود في النموذج
const autoSerial = document.querySelector(
    '#AddTobill input[name="auto_serial"]'
).value;

// عند اختيار الصنف
itemSelect.addEventListener("change", async function () {
    const itemCode = this.value;

    // إعادة ضبط قائمة الباتشات والسعر
    batchSelect.innerHTML = '<option value="">جاري تحميل الباتشات...</option>';
    batchDiv.style.display = "block";
    priceInput.value = "";
    document.getElementById("total_add").value = "";

    try {
       const url =
    `/admin/suppliers_with_ordersGenralReturn/get-batches/${encodeURIComponent(itemCode)}` +
    `?auto_serial=${encodeURIComponent(autoSerial)}`;
      const response = await fetch(url);

const responseText = await response.text();

console.log("Status:", response.status);
console.log("Response:", responseText);

if (!response.ok) {
    throw new Error(
        `تعذر جلب الباتشات. Status: ${response.status}`
    );
}

const result = JSON.parse(responseText);
        batchSelect.innerHTML =
            '<option value="">اختر الباتش</option>';

        if (!result.success || result.batches.length === 0) {
            batchSelect.innerHTML =
                '<option value="">لا توجد باتشات متاحة لهذا الصنف</option>';
            return;
        }

        result.batches.forEach(function (batch) {
            const option = document.createElement("option");

            option.value = batch.auto_serial;
            option.dataset.price = batch.unit_cost_price;
            option.dataset.quantity = batch.quantity;

            option.textContent =
    `باتش رقم ${batch.auto_serial}` +
    ` | الكمية: ${batch.quantity} ${batch.unit_name}` +
    ` | السعر: ${batch.unit_cost_price}`;
                (batch.expire_date
                    ? ` | الانتهاء: ${batch.expire_date}`
                    : "");

            batchSelect.appendChild(option);
        });
    } catch (error) {
        console.error(error);

        batchSelect.innerHTML =
            '<option value="">حدث خطأ أثناء تحميل الباتشات</option>';
    }
});

// عند اختيار الباتش، تعبئة سعره تلقائيًا
batchSelect.addEventListener("change", function () {
    const option = this.options[this.selectedIndex];

    if (!option || !option.value) {
        priceInput.value = "";
        document.getElementById("total_add").value = "";
        return;
    }

    priceInput.value = option.dataset.price;
    calculateTotal();
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

    let itemSelect = document.getElementById("item_code_add");
    let option = itemSelect.options[itemSelect.selectedIndex];
    let itemType = option.dataset.type;

    // التحقق من اختيار الصنف
    if (!item) {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "تنبيه",
            text: "من فضلك، يرجى اختيار الصنف.",
            confirmButtonText: "حسناً",
        });
        return;
    }

    // التحقق من اختيار الوحدة
    if (!unitdata) {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "تنبيه",
            text: "من فضلك، يرجى اختيار الوحدة.",
            confirmButtonText: "حسناً",
        });
        return;
    }

    // التحقق من الكمية
    if (!qty || Number(qty) <= 0) {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "تنبيه",
            text: "من فضلك، يرجى إدخال كمية صحيحة.",
            confirmButtonText: "حسناً",
        });
        return;
    }

    // التحقق من السعر
    if (!price || Number(price) <= 0) {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "تنبيه",
            text: "من فضلك، يرجى إدخال السعر.",
            confirmButtonText: "حسناً",
        });
        return;
    }

    // التحقق من تاريخ الإنتاج والانتهاء فقط إذا لم يتم اختيار باتش
    let batchId = document.getElementById("batch_id").value;

    if (!batchId && itemType == 2) {
        let productiondate = document.getElementById("production_date").value;
        let expirydate = document.getElementById("expir_date").value;

        if (!productiondate) {
            e.preventDefault();
            Swal.fire({
                icon: "warning",
                title: "تنبيه",
                text: "من فضلك، يرجى إدخال تاريخ الإنتاج.",
                confirmButtonText: "حسناً",
            });
            return;
        }

        if (!expirydate) {
            e.preventDefault();
            Swal.fire({
                icon: "warning",
                title: "تنبيه",
                text: "من فضلك، يرجى إدخال تاريخ الانتهاء.",
                confirmButtonText: "حسناً",
            });
            return;
        }

        let prodDate = new Date(productiondate);
        let expDate = new Date(expirydate);

        if (expDate <= prodDate) {
            e.preventDefault();
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

