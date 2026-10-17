// نقل الى تعديل الفاتوره الذ تم فتحها للعميل

document.addEventListener('DOMContentLoaded', function () {

    // قراءة رقم الفاتورة من الرابط
    const params = new URLSearchParams(window.location.search);

    const invoiceSerial = params.get('open_invoice');

    // إذا لا يوجد open_invoice نخرج
    if (!invoiceSerial) {
        return;
    }

    console.log('فتح الفاتورة رقم:', invoiceSerial);

    // ID المودال
    const modalId =
        '#load_invoice_edit_' + invoiceSerial;

    // التأكد أن المودال موجود
    const modal =
        document.querySelector(modalId);

    if (!modal) {

        console.log(
            'لم يتم العثور على المودال:',
            modalId
        );

        return;
    }

    // فتح المودال
    $(modalId).modal('show');

});


