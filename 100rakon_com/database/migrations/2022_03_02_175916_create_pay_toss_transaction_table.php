<?php

use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayTossTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_toss_transactions', function (Blueprint $table) {

            $table->bigIncrements('tossidx');
            $table->unsignedBigInteger('udx')->default(0);
            $table->string('mId', 50)->default("");
            $table->string('version', 10)->default("");
            $table->string('paymentKey', 255)->default("");
            $table->string('orderId', 30)->default("");
            $table->string('orderName', 255)->default("");
            $table->string('method', 20)->default("");
            $table->string('status', 30)->default("");
            $table->datetime('requestedAt')->nullable();
            $table->datetime('approvedAt')->nullable();
            $table->boolean('useEscrow')->default(false);
            $table->boolean('cultureExpense')->default(false);

            $table->string('card_company', 20)->default("");
            $table->string('card_number', 50)->default("");
            $table->integer('card_installmentPlanMonths')->default(0);
            $table->boolean('card_isInterestFree')->default(true);
            $table->string('card_approveNo', 50)->default("");
            $table->boolean('card_useCardPoint')->default(false);
            $table->string('card_cardType', 20)->default("");
            $table->string('card_ownerType', 20)->default("");
            $table->string('card_acauireStatus', 30)->default("");
            $table->text('card_receiptUrl')->default("");

            $table->string('virtual_accountType', 20)->default("");
            $table->string('virtual_accountNumber', 100)->default("");
            $table->string('virtual_bank', 100)->default("");
            $table->string('virtual_customerName', 30)->default("");
            $table->string('virtual_dueDate', 100)->default("");
            $table->string('virtual_refundStatus', 20)->default("");
            $table->boolean('virtual_expired')->default(false);
            $table->string('virtual_settlementStatus', 30)->default("");

            $table->string('transfer_bank', 50)->default("");
            $table->string('transfer_settlementStatus', 30)->default("");
            $table->string('mobile_carrier', 30)->default("");
            $table->string('mobile_customerMobilePhone', 30)->default("");
            $table->string('mobile_settlementStatus', 30)->default("");
            $table->string('gift_approveNo', 50)->default("");
            $table->string('gift_settlementStatus', 30)->default("");

            $table->string('cashRct_type', 10)->default("");
            $table->integer('cashRct_amount')->default(0);
            $table->integer('cashRct_taxFreeAmount')->default(0);
            $table->string('cashRct_issueNumber', 50)->default("");
            $table->text('cashRct_receiptUrl')->default("");

            $table->integer('cancel_amount')->default(0);
            $table->text('cancel_reason')->default("");
            $table->integer('cancel_taxFreeAmount')->default(0);
            $table->integer('cancel_taxAmount')->default(0);
            $table->integer('cancel_refundableAmount')->default(0);
            $table->datetime('cancel_canceledAt')->nullable();

            $table->integer('card_discount_amount')->default(0);
            $table->string('secret', 100)->default("");
            $table->string('type', 30)->default("");
            $table->string('easyPay', 30)->default("");
            $table->string('currency', 3)->default("KRW");
            $table->integer('totalAmount')->default(0);
            $table->integer('balanceAmount')->default(0);
            $table->integer('suppliedAmount')->default(0);
            $table->integer('vat')->default(0);
            $table->integer('taxFreeAmount')->default(0);

            $table->unsignedTinyInteger('state')->default(10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('udx')->references('udx')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_toss_transactions');
    }
}
