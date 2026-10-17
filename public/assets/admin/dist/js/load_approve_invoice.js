
    document.addEventListener('DOMContentLoaded', function () {
        // الحقول الأساسية
        const totalCostInput = document.getElementById('total_cost');
        const taxPercentInput = document.getElementById('tax_percent');
        const taxValueInput = document.getElementById('tax_value');
        const totalBeforeDiscountInput = document.getElementById('total_before_discount');

        // حقول الخصم
        const discountTypeSelect = document.getElementById('discount_type');
        const discountPercentInput = document.getElementById('discount_percent');
        const discountValueInput = document.getElementById('discount_value');
        const totalAfterDiscountInput = document.getElementById('total_after_discount');

        // مكان عرض رسالة الخطأ
        let errorMsg = document.getElementById('discount_error_msg');
        if (!errorMsg) {
            errorMsg = document.createElement('small');
            errorMsg.id = 'discount_error_msg';
            errorMsg.classList.add('text-danger', 'd-block', 'mt-1');
            discountPercentInput.parentNode.appendChild(errorMsg);
        }

        function showError(message) {
            errorMsg.textContent = message;
            discountPercentInput.classList.add('is-invalid');
        }

        function clearError() {
            errorMsg.textContent = '';
            discountPercentInput.classList.remove('is-invalid');
        }

        function calculateAll() {
            // 1) حساب الضريبة والإجمالي قبل الخصم
            const totalCost = parseFloat(totalCostInput.value) || 0;
            const taxPercent = parseFloat(taxPercentInput.value) || 0;

            const taxValue = totalCost * (taxPercent / 100);
            const totalBeforeDiscount = totalCost + taxValue;

            taxValueInput.value = taxValue;
            totalBeforeDiscountInput.value = totalBeforeDiscount;

            // 2) التحقق من الشرط: نسبة الضريبة لازم تكون أكبر من نسبة الخصم
            const discountType = discountTypeSelect.value;
            const discountInput = parseFloat(discountPercentInput.value) || 0;

            // الشرط بيتفعّل بس لو نوع الخصم "نسبة مئوية"
            if (discountType === '1' && discountInput >= taxPercent) {
                showError('نسبة الخصم لازم تكون أقل من نسبة الضريبة (' + taxPercent + '%)');

                // نصفّر قيم الخصم عشان منحسبش بقيمة غلط
                discountValueInput.value = '0.00';
                totalAfterDiscountInput.value = totalBeforeDiscount;
                return; // نوقف الحساب هنا
            } else {
                clearError();
            }

            // 3) حساب الخصم بناءً على نوعه
            let discountValue = 0;

            if (discountType === '1') {
                // نسبة مئوية
                discountValue = totalBeforeDiscount * (discountInput / 100);
            } else if (discountType === '2') {
                // قيمة ثابتة
                discountValue = discountInput;

                // حماية من إن الخصم الثابت يتعدى الإجمالي
                if (discountValue > totalBeforeDiscount) {
                    discountValue = totalBeforeDiscount;
                }
            } else {
                discountValue = 0;
            }

            discountValueInput.value = discountValue;

            // 4) الإجمالي النهائي بعد الخصم
            const totalAfterDiscount = totalBeforeDiscount - discountValue;
            totalAfterDiscountInput.value = totalAfterDiscount;
        }

        // شغّل الحساب أول ما الصفحة تفتح
        calculateAll();

        // إعادة الحساب عند أي تغيير في الحقول المؤثرة
        totalCostInput.addEventListener('input', calculateAll);
        taxPercentInput.addEventListener('input', calculateAll);
        discountTypeSelect.addEventListener('change', calculateAll);
        discountPercentInput.addEventListener('input', calculateAll);
    });
    // ------------------------------------------------------------------------------------------------
    function calculatePaidRemain() {
        const billType = document.getElementById('bill_type').value;
        const total = parseFloat(document.getElementById('total_after_discount').value) || 0;
        const paidInput = document.getElementById('paid');
        const remainInput = document.getElementById('remain');
        const errorEl = document.getElementById('paid_error');

        if (billType == '1') {
            // كاش: يدفع الإجمالي كامل ومينفعش يتعدل
            paidInput.value = total.toFixed(2);
            paidInput.readOnly = true;
            remainInput.value = '0.00';
            errorEl.innerHTML = '';

        } else if (billType == '0') {
            // آجل: المستخدم بيدخل مبلغ جزئي بنفسه
            paidInput.readOnly = false;

            const paid = parseFloat(paidInput.value) || 0;

            if (paid >= total) {
                errorEl.innerHTML = 'في حالة الآجل يجب أن يكون المبلغ المدفوع أقل من إجمالي الفاتورة';
                remainInput.value = '0.00';
            } else {
                errorEl.innerHTML = '';
                remainInput.value = (total - paid).toFixed(2);
            }

        } else {
            // مفيش نوع محدد
            paidInput.readOnly = true;
            paidInput.value = '';
            remainInput.value = '';
            errorEl.innerHTML = '';
        }
    }

    // عند تغيير نوع الفاتورة (كاش / آجل)
    document.getElementById('bill_type').addEventListener('change', calculatePaidRemain);

    // عند كتابة المبلغ المدفوع (في حالة الآجل فقط، لأن الكاش readonly)
    document.getElementById('paid').addEventListener('input', calculatePaidRemain);

    // تشغيل الحساب أول ما الصفحة تفتح (لو فيه قيم محفوظة من قبل)
    document.addEventListener('DOMContentLoaded', calculatePaidRemain);


    document.getElementById('bill_type').addEventListener('change', calculatePaidRemain);

    // عند فتح الصفحة
    calculatePaidRemain();

    // التحقق من

    document.getElementById('approve_invoice_form').addEventListener('submit', function (e) {
        const treasuryBalance = parseFloat(document.getElementById('treasury_balance').value) || 0;
        const paidAmount = parseFloat(document.getElementById('paid').value) || 0;
        const errorEl = document.getElementById('treasury_error');

        if (treasuryBalance <= 0) {
            e.preventDefault();
            errorEl.innerHTML = 'رصيد الخزنة صفر، لا يمكن اعتماد الفاتورة';
            return;
        }

        if (paidAmount > treasuryBalance) {
            e.preventDefault();
            errorEl.innerHTML = 'مبلغ الاعتماد أكبر من رصيد الخزنة المتاح';
            return;
        }

        errorEl.innerHTML = '';
    });




