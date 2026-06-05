<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_v1', function (Blueprint $table) {
            $table->id();

            $table->string('order_code', 50)->unique()->comment('Mã đơn hàng nội bộ trên web');
            $table->unsignedBigInteger('id_cart_v1')->nullable()->comment('Giỏ hàng gốc tạo ra đơn');
            $table->string('cart_token', 100)->nullable()->comment('Token giỏ hàng để trace');

            $table->string('customer_name', 255)->comment('Tên người đặt/người nhận');
            $table->string('customer_phone', 20)->comment('Số điện thoại khách');
            $table->string('customer_email', 255)->nullable()->comment('Email khách hàng');

            $table->unsignedTinyInteger('receive_type')->default(1)->comment('1: giao tận nơi, 2: nhận tại nhà thuốc');
            $table->unsignedBigInteger('id_branch_pickup')->nullable()->comment('Chi nhánh khách chọn nhận hàng nếu pickup');
            $table->unsignedBigInteger('id_branch_process')->nullable()->comment('Chi nhánh xử lý thực tế do admin chọn');

            $table->string('province_name', 255)->nullable()->comment('Tỉnh/thành');
            $table->string('district_name', 255)->nullable()->comment('Quận/huyện');
            $table->string('ward_name', 255)->nullable()->comment('Phường/xã');
            $table->text('address_detail')->nullable()->comment('Địa chỉ chi tiết');

            $table->text('note')->nullable()->comment('Ghi chú của khách');
            $table->unsignedTinyInteger('payment_method')->default(1)->comment('1: COD, 2: chuyển khoản, 3: thanh toán tại quầy');
            $table->unsignedTinyInteger('payment_status')->default(0)->comment('0: chưa thanh toán, 1: đã thanh toán, 2: thanh toán một phần, 3: hoàn tiền');

            $table->decimal('subtotal_amount', 15, 2)->default(0)->comment('Tổng tiền hàng');
            $table->decimal('discount_amount', 15, 2)->default(0)->comment('Số tiền giảm giá');
            $table->decimal('shipping_fee', 15, 2)->default(0)->comment('Phí giao hàng');
            $table->decimal('total_amount', 15, 2)->default(0)->comment('Tổng thanh toán cuối cùng');

            $table->unsignedTinyInteger('order_status')->default(0)->comment('0: mới, 1: đã xác nhận, 2: đang xử lý, 3: chờ sync KiotViet, 4: đã sync, 5: đang giao, 6: hoàn thành, 7: đã hủy');
            $table->unsignedTinyInteger('requires_consult')->default(0)->comment('0: không cần tư vấn, 1: cần dược sĩ gọi xác nhận');

            $table->text('admin_note')->nullable()->comment('Ghi chú nội bộ của admin');
            $table->unsignedBigInteger('confirmed_by')->nullable()->comment('ID user admin xác nhận đơn');
            $table->timestamp('confirmed_at')->nullable()->comment('Thời gian xác nhận đơn');

            $table->unsignedBigInteger('cancelled_by')->nullable()->comment('ID user admin hủy đơn');
            $table->timestamp('cancelled_at')->nullable()->comment('Thời gian hủy đơn');
            $table->text('cancel_reason')->nullable()->comment('Lý do hủy đơn');

            $table->unsignedTinyInteger('sync_kiotviet_status')->default(0)->comment('0: chưa sync, 1: sẵn sàng sync, 2: sync thành công, 3: sync lỗi');
            $table->unsignedBigInteger('kiotviet_branch_id')->nullable()->comment('branchId bên KiotViet dùng khi sync');
            $table->unsignedBigInteger('kiotviet_customer_id')->nullable()->comment('customerId bên KiotViet');
            $table->unsignedBigInteger('kiotviet_sold_by_id')->nullable()->comment('soldById bên KiotViet');
            $table->unsignedBigInteger('kiotviet_order_id')->nullable()->comment('ID order bên KiotViet nếu có');
            $table->unsignedBigInteger('kiotviet_invoice_id')->nullable()->comment('ID invoice bên KiotViet nếu sync hóa đơn');
            $table->string('kiotviet_invoice_code', 100)->nullable()->comment('Mã hóa đơn bên KiotViet');
            $table->text('sync_kiotviet_error')->nullable()->comment('Thông báo lỗi sync gần nhất');
            $table->timestamp('synced_at')->nullable()->comment('Thời điểm sync thành công');

            $table->timestamps();

            $table->index(['order_status']);
            $table->index(['sync_kiotviet_status']);
            $table->index(['customer_phone']);
            $table->index(['receive_type']);
            $table->index(['id_branch_pickup']);
            $table->index(['id_branch_process']);
            $table->index(['kiotviet_customer_id']);
            $table->index(['kiotviet_invoice_id']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_v1');
    }
};