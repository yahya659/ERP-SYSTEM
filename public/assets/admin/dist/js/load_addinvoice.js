// ============================================================
// إضافة الأصناف للفاتورة المبيعات
// ============================================================

// ============================================================
// بيانات العميل
// ============================================================

document.addEventListener("DOMContentLoaded", function () {
    const customerSelect = document.getElementById("is_has_customer");
    const customerData = document.getElementById("customerData");

    if (!customerSelect || !customerData) {
        return;
    }

    customerSelect.addEventListener("change", function () {
        customerData.style.display = this.value === "1" ? "block" : "none";
    });
});

// ============================================================
// العناصر الأساسية
// ============================================================

const storeSelect = document.getElementById("store_id");
const itemSelect = document.getElementById("item_code");
const unitSelect = document.getElementById("unit_id");

const invItemBatches = window.invItemBatches || [];

// ============================================================
// عند اختيار الصنف
// إظهار الوحدات + الحقول
// ============================================================

itemSelect.addEventListener("change", function () {
    const option = this.options[this.selectedIndex];

    const main = option.dataset.main;
    const mainName = option.dataset.mainName;

    const retail = option.dataset.retail;
    const retailName = option.dataset.retailName;

    // إذا لم يتم اختيار صنف
    if (!main) {
        hideItemFields();

        unitSelect.innerHTML = `<option value="">اختر الوحدة</option>`;

        return;
    }

    // إظهار الحقول
    showItemFields();

    // تنظيف الوحدات
    unitSelect.innerHTML = `<option value="">اختر الوحدة</option>`;

    // وحدة الأب
    if (main && mainName) {
        unitSelect.innerHTML += `
            <option value="${main}">
                ${mainName} (وحدة الأب)
            </option>
        `;
    }

    // وحدة التجزئة
    if (retail && retailName) {
        unitSelect.innerHTML += `
            <option value="${retail}">
                ${retailName} (وحدة التجزئة)
            </option>
        `;
    }

    // تحديث كمية المخزون
    getAvailableQuantity();

    // عرض باتشات الصنف الاستهلاكي
    showConsumerBatches();
});

// ============================================================
// إخفاء حقول الصنف
// ============================================================

function hideItemFields() {
    document.getElementById("unit_div").style.display = "none";
    document.getElementById("quantity_div").style.display = "none";
    document.getElementById("price_div").style.display = "none";
    document.getElementById("total_div").style.display = "none";
}

// ============================================================
// إظهار حقول الصنف
// ============================================================

function showItemFields() {
    document.getElementById("unit_div").style.display = "block";
    document.getElementById("quantity_div").style.display = "block";
    document.getElementById("price_div").style.display = "block";
    document.getElementById("total_div").style.display = "block";
}

// ============================================================
// حساب إجمالي البيع
// الكمية × سعر الوحدة
// ============================================================

function calculateTotal() {
    const quantity = parseFloat(document.getElementById("quantity").value) || 0;

    const price = parseFloat(document.getElementById("unit_price").value) || 0;

    const total = quantity * price;

    document.getElementById("total_price").value = total.toFixed(2);
}

// عند تغيير كمية البيع
document.getElementById("quantity").addEventListener("input", calculateTotal);

// عند تغيير السعر
document.getElementById("unit_price").addEventListener("input", calculateTotal);

// ============================================================
// عند اختيار وحدة البيع
// تغيير اسم السعر + تحديث كمية المخزون
// ============================================================

unitSelect.addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];

    const label = document.getElementById("unit_price_label");

    // تغيير اسم السعر
    if (!this.value) {
        label.innerText = "سعر الوحدة";
    } else {
        let unitName = selectedOption.text
            .replace("(وحدة الأب)", "")
            .replace("(وحدة التجزئة)", "")
            .trim();

        label.innerText = "سعر الوحدة (" + unitName + ")";
    }

    // تحديث كمية المخزون
    updateAvailableQuantity();
});

// ============================================================
// جلب كمية الصنف الموجودة في المخزن
// ============================================================

function getAvailableQuantity() {
    const storeId = storeSelect.value;
    const itemCode = itemSelect.value;

    const availableQuantityDiv = document.getElementById(
        "available_quantity_div",
    );

    const availableQuantity = document.getElementById("available_quantity");

    // إذا لم يتم اختيار المخزن أو الصنف
    if (!storeId || !itemCode) {
        availableQuantity.value = "";
        availableQuantity.dataset.retailQuantity = "0";

        availableQuantityDiv.style.display = "none";

        return;
    }

    // الباتشات الخاصة بالمخزن والصنف
    const batches = invItemBatches.filter(function (batch) {
        return (
            String(batch.store_id) === String(storeId) &&
            String(batch.item_code) === String(itemCode) &&
            Number(batch.quantity) > 0
        );
    });

    // جمع الكمية الموجودة في جميع الباتشات
    const totalQuantity = batches.reduce(function (total, batch) {
        return total + Number(batch.quantity);
    }, 0);

    // حفظ الكمية الأصلية بوحدة التجزئة
    availableQuantity.dataset.retailQuantity = totalQuantity;

    // إظهار القسم
    availableQuantityDiv.style.display = "block";

    // تحديث الكمية حسب الوحدة
    updateAvailableQuantity();
}

// ============================================================
// تحديث كمية المخزون حسب الوحدة المختارة
// ============================================================

function updateAvailableQuantity() {
    const availableQuantity = document.getElementById("available_quantity");

    const option = itemSelect.options[itemSelect.selectedIndex];

    // لا يوجد صنف
    if (!option || !itemSelect.value) {
        return;
    }

    // الكمية المخزنة بوحدة التجزئة
    const retailQuantity =
        Number(availableQuantity.dataset.retailQuantity) || 0;

    // عدد وحدات التجزئة داخل وحدة الأب
    const retailQty = Number(option.dataset.retailQty) || 1;

    // وحدة الأب
    const main = option.dataset.main;

    // وحدة التجزئة
    const retail = option.dataset.retail;

    const mainName = option.dataset.mainName || "وحدة الأب";

    const retailName = option.dataset.retailName || "وحدة التجزئة";

    // ========================================================
    // اختيار وحدة الأب
    // مثال:
    // 250 حبة ÷ 24 = 10 كراتين + 10 حبات
    // ========================================================

    if (unitSelect.value == main) {
        const mainQuantity = Math.floor(retailQuantity / retailQty);

        const remainingQuantity = retailQuantity % retailQty;

        if (remainingQuantity > 0) {
            availableQuantity.value =
                mainQuantity +
                " " +
                mainName +
                " و " +
                remainingQuantity +
                " " +
                retailName;
        } else {
            availableQuantity.value = mainQuantity + " " + mainName;
        }

        return;
    }

    // ========================================================
    // اختيار وحدة التجزئة
    // مثال:
    // 240 حبة = 240 حبة
    // ========================================================

    if (unitSelect.value == retail) {
        availableQuantity.value = retailQuantity + " " + retailName;

        return;
    }

    // ========================================================
    // لم يتم اختيار وحدة
    // ========================================================

    availableQuantity.value = retailQuantity + " " + retailName;
}

// ============================================================
// عرض باتشات الصنف الاستهلاكي
// مع مقارنة تاريخ الانتهاء
// ============================================================

function showConsumerBatches() {
    const storeId = storeSelect.value;

    const itemCode = itemSelect.value;

    const option = itemSelect.options[itemSelect.selectedIndex];

    const batchesDiv = document.getElementById("consumer_batches_div");

    const batchesTable = document.getElementById("consumer_batches");

    // تنظيف الجدول
    batchesTable.innerHTML = "";

    // إذا لم يتم اختيار المخزن أو الصنف
    if (!storeId || !itemCode || !option.value) {
        batchesDiv.style.display = "none";

        return;
    }

    // نوع الصنف
    const itemType = option.dataset.itemType;

    // عرض الباتشات للاصناف الاستهلاكية فقط
    if (itemType != "2") {
        batchesDiv.style.display = "none";

        return;
    }

    // جلب باتشات الصنف من المخزن
    const batches = invItemBatches.filter(function (batch) {
        return (
            String(batch.store_id) === String(storeId) &&
            String(batch.item_code) === String(itemCode) &&
            Number(batch.quantity) > 0
        );
    });

    // إظهار القسم
    batchesDiv.style.display = "block";

    // لا توجد كميات
    if (batches.length === 0) {
        batchesTable.innerHTML = `
            <tr>
                <td colspan="4" class="text-danger">
                    لا توجد كمية متوفرة لهذا الصنف في هذا المخزن
                </td>
            </tr>
        `;

        return;
    }

    // تاريخ اليوم
    const today = new Date();

    today.setHours(0, 0, 0, 0);

    // عرض الباتشات
    batches.forEach(function (batch) {
        const expireDate = new Date(batch.expire_date);

        expireDate.setHours(0, 0, 0, 0);

        // حساب الفرق بالأيام
        const difference = Math.ceil(
            (expireDate - today) / (1000 * 60 * 60 * 24),
        );

        let status;
        let rowClass;

        // ====================================================
        // منتهي الصلاحية
        // ====================================================

        if (difference < 0) {
            status = `
                <span class="badge badge-danger">
                    منتهي الصلاحية
                </span>
            `;

            rowClass = "table-danger";
        }

        // ====================================================
        // قريب الانتهاء خلال 30 يوم
        // ====================================================
        else if (difference <= 30) {
            status = `
                <span class="badge badge-warning">
                    قريب الانتهاء
                    (${difference} يوم)
                </span>
            `;

            rowClass = "table-warning";
        }

 
        // صالح

        else {
            status = `
                <span class="badge badge-success">
                    صالح
                </span>
            `;

            rowClass = "table-success";
        }

        // إضافة الباتش إلى الجدول


        batchesTable.innerHTML += `
            <tr class="${rowClass}">

                <td>
                    ${Number(batch.auto_serial)}

                </td>
                <td>
                    ${Number(batch.quantity /24)}
                    كرتون
                </td>

                <td>
                    ${batch.production_date ?? "-"}
                </td>

                <td>
                    ${batch.expire_date ?? "-"}
                </td>

                <td>
                    ${status}
                </td>

            </tr>
        `;
    });
}

// ============================================================
// عند تغيير المخزن
// ============================================================

storeSelect.addEventListener("change", function () {
    getAvailableQuantity();

    showConsumerBatches();
});

// ============================================================
// عند تغيير الصنف
// ============================================================

itemSelect.addEventListener("change", function () {
    getAvailableQuantity();

    showConsumerBatches();
});
// -------------------------------------------------------------------------------------------------------------
unitSelect.addEventListener("change", function () {
    let itemOption = itemSelect.options[itemSelect.selectedIndex];

    if (!itemOption || !itemSelect.value || !this.value) {
        document.getElementById("unit_price").value = "";
        return;
    }

    // أسعار الصنف
    let price = Number(itemOption.dataset.price) || 0;
    let retailPrice = Number(itemOption.dataset.retailPrice) || 0;

    // الوحدة المختارة
    let selectedUnit = this.value;

    // وحدة الأب
    let mainUnit = itemOption.dataset.main;

    // وحدة التجزئة
    let retailUnit = itemOption.dataset.retail;

    // إذا اختار وحدة الأب
    if (selectedUnit == mainUnit) {
        document.getElementById("unit_price").value = price.toFixed(2);
    }

    // إذا اختار وحدة التجزئة
    else if (selectedUnit == retailUnit) {
        document.getElementById("unit_price").value = retailPrice.toFixed(2);
    } else {
        document.getElementById("unit_price").value = "";
    }

    // تحديث اسم السعر
    let unitName = this.options[this.selectedIndex].text
        .replace("(وحدة الأب)", "")
        .replace("(وحدة التجزئة)", "")
        .trim();

    document.getElementById("unit_price_label").innerText =
        "سعر الوحدة (" + unitName + ")";

    // إعادة حساب الإجمالي
    calculateTotal();
});

// ----------------------------------------------------------------------------------
// ============================================================
// تحديد سعر الصنف حسب:
// 1- نوع البيع
// 2- وحدة البيع
// ============================================================

function updateUnitPrice() {
    const itemSelect = document.getElementById("item_code");
    const unitSelect = document.getElementById("unit_id");
    const salesType = document.getElementById("sales_item_type");
    const unitPrice = document.getElementById("unit_price");

    // إذا لم يتم اختيار صنف أو وحدة أو نوع بيع
    if (!itemSelect.value || !unitSelect.value || !salesType.value) {
        unitPrice.value = "";

        calculateTotal();

        return;
    }

    const option = itemSelect.options[itemSelect.selectedIndex];

    // أسعار وحدة الأب
    const price = Number(option.dataset.price) || 0;

    const nosGomlaPrice = Number(option.dataset.nosGomlaPrice) || 0;

    const wholesalePrice = Number(option.dataset.wholesalePrice) || 0;

    // أسعار وحدة التجزئة
    const priceRetail = Number(option.dataset.priceRetail) || 0;

    const nosGomlaPriceRetail = Number(option.dataset.nosGomlaPriceRetail) || 0;

    const wholesalePriceRetail =
        Number(option.dataset.wholesalePriceRetail) || 0;

    // ========================================================
    // وحدة الأب
    // ========================================================

    if (unitSelect.value == option.dataset.main) {
        if (salesType.value == "1") {
            unitPrice.value = price;
        } else if (salesType.value == "2") {
            unitPrice.value = nosGomlaPrice;
        } else if (salesType.value == "3") {
            unitPrice.value = wholesalePrice;
        }
    }

    // ========================================================
    // وحدة التجزئة
    // ========================================================
    else if (unitSelect.value == option.dataset.retail) {
        if (salesType.value == "1") {
            unitPrice.value = priceRetail;
        } else if (salesType.value == "2") {
            unitPrice.value = nosGomlaPriceRetail;
        } else if (salesType.value == "3") {
            unitPrice.value = wholesalePriceRetail;
        }
    }

    // حساب الإجمالي بعد تغيير السعر
    calculateTotal();
}
document
    .getElementById("sales_item_type")
    .addEventListener("change", updateUnitPrice);
document.getElementById("unit_id").addEventListener("change", updateUnitPrice);

// --------------------------------------------------------------------------------
// ============================================================
// التحقق من بيانات الصنف قبل إضافته للفاتورة
// ============================================================

document
    .getElementById("addInvoiceItem")
    .addEventListener("click", function () {
        // ========================================================
        // جلب البيانات
        // ========================================================

        const storeId = document.getElementById("store_id").value;

        const salesType = document.getElementById("sales_item_type").value;

        const itemCode = document.getElementById("item_code").value;

        const unitId = document.getElementById("unit_id").value;

        const quantity = Number(document.getElementById("quantity").value) || 0;

        // ========================================================
        // التحقق من المخزن
        // ========================================================

        if (!storeId) {
            alert("يرجى اختيار المخزن");

            return;
        }

        // ========================================================
        // التحقق من نوع البيع
        // ========================================================

        if (!salesType) {
            alert("يرجى اختيار نوع البيع");

            return;
        }

        // ========================================================
        // التحقق من الصنف
        // ========================================================

        if (!itemCode) {
            alert("يرجى اختيار الصنف");

            return;
        }

        // ========================================================
        // التحقق من الوحدة
        // ========================================================

        if (!unitId) {
            alert("يرجى اختيار وحدة البيع");

            return;
        }

        // ========================================================
        // التحقق من الكمية
        // ========================================================

        if (quantity <= 0) {
            alert("يرجى إدخال كمية البيع");

            return;
        }

        // ========================================================
        // جلب الكمية الموجودة في المخزن
        // ========================================================

        const availableQuantityInput =
            document.getElementById("available_quantity");

        const retailQuantity =
            Number(availableQuantityInput.dataset.retailQuantity) || 0;

        // ========================================================
        // جلب بيانات الصنف والوحدة
        // ========================================================

        const itemOption =
            document.getElementById("item_code").options[
                document.getElementById("item_code").selectedIndex
            ];

        const mainUnit = itemOption.dataset.main;

        const retailUnit = itemOption.dataset.retail;

        const retailQty = Number(itemOption.dataset.retailQty) || 1;

        // ========================================================
        // تحويل الكمية المطلوبة إلى وحدة التجزئة
        //
        // لأن المخزون عندنا مخزن دائمًا بوحدة التجزئة
        // ========================================================

        let requestedRetailQuantity = 0;

        // إذا كانت وحدة البيع هي وحدة الأب
        if (unitId == mainUnit) {
            requestedRetailQuantity = quantity * retailQty;
        }

        // إذا كانت وحدة البيع هي وحدة التجزئة
        else if (unitId == retailUnit) {
            requestedRetailQuantity = quantity;
        }

        // ========================================================
        // مقارنة الكمية المطلوبة مع كمية المخزن
        // ========================================================

        if (requestedRetailQuantity > retailQuantity) {
            alert("الكمية المطلوبة أكبر من الكمية الموجودة في المخزن");

            return;
        }

        // ========================================================
        // جلب أسماء البيانات المختارة
        // ========================================================

        const storeName =
            document.getElementById("store_id").options[
                document.getElementById("store_id").selectedIndex
            ].text;

        const salesTypeName =
            document.getElementById("sales_item_type").options[
                document.getElementById("sales_item_type").selectedIndex
            ].text;

        const itemName =
            document.getElementById("item_code").options[
                document.getElementById("item_code").selectedIndex
            ].text;

        let unitName =
            document.getElementById("unit_id").options[
                document.getElementById("unit_id").selectedIndex
            ].text;

        // إزالة النصوص الإضافية من اسم الوحدة
        let unitType = "";

        if (unitId == mainUnit) {
            unitType = "جملة";
        } else if (unitId == retailUnit) {
            unitType = "تجزئة";
        }

        // ========================================================
        // جلب السعر والإجمالي
        // ========================================================

        const unitPrice =
            Number(document.getElementById("unit_price").value) || 0;

        const totalPrice =
            Number(document.getElementById("total_price").value) || 0;

        // ========================================================
        // حذف رسالة عدم وجود أصناف
        // ========================================================

        const emptyItems = document.getElementById("emptyItems");

        if (emptyItems) {
            emptyItems.remove();
        }

        // ========================================================
        // إضافة الصنف إلى جدول الفاتورة
        // ========================================================

        const invoiceItems = document.getElementById("invoiceItems");

        invoiceItems.innerHTML += `

    <tr>

        <td>
            ${storeName}
        </td>

        <td>
            ${salesTypeName}
        </td>

        <td>
            ${itemName}
        </td>

        <td>
         ${unitType}__${unitName}
        </td>

        <td>
            ${unitPrice.toFixed(2)}
        </td>

        <td>
            ${quantity}
        </td>

        <td class="item-total">
            ${totalPrice.toFixed(2)}
        </td>

        <td>

            <button
                type="button"
                class="btn btn-danger btn-sm delete-item">

                <i class="fas fa-trash"></i>
                حذف

            </button>

        </td>

    </tr>

`;

        // ========================================================
        // تحديث إجمالي الفاتورة
        // ========================================================

        updateInvoiceTotal();
    });
// ============================================================
// حساب إجمالي الفاتورة
// ============================================================

function updateInvoiceTotal() {
    let total = 0;

    document.querySelectorAll(".item-total").forEach(function (item) {
        total += Number(item.innerText) || 0;
    });

    // إجمالي جدول الأصناف
    document.getElementById("invoiceTotal").innerText = total.toFixed(2);

    // إجمالي الأصناف في فورم الاعتماد
    document.getElementById("total_items_price").value = total.toFixed(2);
}
// ============================================================
// حذف صنف من جدول الفاتورة
// ============================================================

document.getElementById("invoiceItems").addEventListener("click", function (e) {
    // البحث عن زر الحذف
    const deleteButton = e.target.closest(".delete-item");

    // إذا لم يكن الضغط على زر الحذف
    if (!deleteButton) {
        return;
    }

    // جلب الصف
    const row = deleteButton.closest("tr");

    // حذف الصف
    row.remove();

    // ====================================================
    // إذا لم يتبق أي صنف
    // نعيد رسالة "لم يتم إضافة أي صنف"
    // ====================================================

    const items = document.querySelectorAll("#invoiceItems tr");

    if (items.length === 0) {
        document.getElementById("invoiceItems").innerHTML = `

                <tr id="emptyItems">

                    <td colspan="8" class="text-muted">
                       الفاتوره خاليه ...لايوجد اصناف
                    </td>

                </tr>

            `;
    }

    // ====================================================
    // إعادة حساب إجمالي الفاتورة
    // ====================================================

    updateInvoiceTotal();
});
// ============================================================
// حساب قيمة ضريبة القيمة المضافة
// ============================================================

// ============================================================
// حساب قيمة ضريبة القيمة المضافة
// ============================================================

function calculateTax() {
    const totalItemsElement = document.getElementById("total_items_price");

    const taxPercentageElement = document.getElementById("tax_percentage");

    const taxValueElement = document.getElementById("tax_value");

    const totalWithTaxElement = document.getElementById("total_with_tax");

    if (
        !totalItemsElement ||
        !taxPercentageElement ||
        !taxValueElement ||
        !totalWithTaxElement
    ) {
        return;
    }

    // إجمالي الأصناف
    const totalItems = Number(totalItemsElement.value) || 0;

    // نسبة الضريبة
    const taxPercentage = Number(taxPercentageElement.value) || 0;

    // قيمة الضريبة
    const taxValue = (totalItems * taxPercentage) / 100;

    // الإجمالي مع الضريبة
    const totalWithTax = totalItems + taxValue;

    // عرض النتائج
    taxValueElement.value = taxValue.toFixed(2);

    totalWithTaxElement.value = totalWithTax.toFixed(2);
    calculateDiscount();
}

// ============================================================
// عند تغيير نسبة الضريبة
// ============================================================

document.addEventListener("DOMContentLoaded", function () {
    const taxPercentage = document.getElementById("tax_percentage");

    if (taxPercentage) {
        taxPercentage.addEventListener("input", calculateTax);
    }
});
function updateInvoiceTotal() {
    let total = 0;

    document.querySelectorAll(".item-total").forEach(function (item) {
        total += Number(item.innerText) || 0;
    });

    // إجمالي الفاتورة في الجدول
    document.getElementById("invoiceTotal").innerText = total.toFixed(2);

    // إجمالي الأصناف في فورم الاعتماد
    document.getElementById("total_items_price").value = total.toFixed(2);

    // إعادة حساب الضريبة
    calculateTax();
}
// ============================================================
// حساب الخصم
// ============================================================

// ============================================================
// حساب الخصم + الإجمالي النهائي
// ============================================================

function calculateDiscount() {
    // الإجمالي بعد الضريبة
    const totalWithTax =
        Number(document.getElementById("total_with_tax").value) || 0;

    // نوع الخصم
    const discountType = document.getElementById("discount_type").value;

    // قيمة الإدخال
    const discountInput =
        Number(document.getElementById("discount_input").value) || 0;

    let discountValue = 0;

    // ========================================================
    // إذا كان الخصم نسبة مئوية
    // ========================================================

    if (discountType === "percentage") {
        discountValue = (totalWithTax * discountInput) / 100;
    }

    // ========================================================
    // إذا كان الخصم مبلغ ثابت
    // ========================================================
    else if (discountType === "fixed") {
        discountValue = discountInput;
    }

    // ========================================================
    // منع الخصم من تجاوز الإجمالي
    // ========================================================

    if (discountValue > totalWithTax) {
        discountValue = totalWithTax;
    }

    // ========================================================
    // عرض قيمة الخصم
    // ========================================================

    document.getElementById("discount_value").value = discountValue.toFixed(2);

    // ========================================================
    // حساب الإجمالي النهائي
    // ========================================================

    const finalTotal = totalWithTax - discountValue;

    document.getElementById("final_total").value = finalTotal.toFixed(2);
}

document.addEventListener("DOMContentLoaded", function () {
    const discountType = document.getElementById("discount_type");

    const discountInput = document.getElementById("discount_input");

    if (discountType) {
        discountType.addEventListener("change", function () {
            const label = document.getElementById("discount_input_label");

            if (this.value === "percentage") {
                label.innerText = "نسبة الخصم";
            } else {
                label.innerText = "قيمة الخصم";
            }

            calculateDiscount();
        });
    }

    if (discountInput) {
        discountInput.addEventListener("input", calculateDiscount);
    }
});

// ============================================================
// التحقق من نوع الفاتورة + حساب المتبقي
// ============================================================

function calculateRemainingAmount() {
    const finalTotal =
        Number(document.getElementById("final_total").value) || 0;

    const paidInput = document.getElementById("paid_amount");

    const remainingInput = document.getElementById("remaining_amount");

    const invoiceType = document.getElementById("invoice_type").value;

    let paidAmount = Number(paidInput.value) || 0;

    // ========================================================
    // منع المبلغ المحصل من تجاوز الإجمالي
    // ========================================================

    if (paidAmount > finalTotal) {
        paidAmount = finalTotal;

        paidInput.value = finalTotal.toFixed(2);

        alert("المبلغ المحصل لا يمكن أن يكون أكبر من إجمالي الفاتورة.");
    }

    // ========================================================
    // فاتورة كاش
    // يجب دفع كامل المبلغ
    // ========================================================

    if (invoiceType === "cash") {
        paidInput.value = finalTotal.toFixed(2);

        remainingInput.value = "0.00";

        return;
    }

    // ========================================================
    // فاتورة آجل
    // يجب أن يبقى مبلغ على العميل
    // ========================================================

    if (invoiceType === "credit") {
        if (paidAmount >= finalTotal && finalTotal > 0) {
            paidAmount = finalTotal - 0.01;

            paidInput.value = paidAmount.toFixed(2);

            alert("الفاتورة الآجلة يجب أن يتبقى منها مبلغ على العميل.");
        }

        const remainingAmount = finalTotal - paidAmount;

        remainingInput.value = remainingAmount.toFixed(2);
    }
}
document.getElementById("invoice_type").addEventListener("change", function () {
    calculateRemainingAmount();
});
function updateInvoicePayment() {
    calculateRemainingAmount();
}
// عند تغيير المبلغ المحصل
document
    .getElementById("paid_amount")
    .addEventListener("input", calculateRemainingAmount);
