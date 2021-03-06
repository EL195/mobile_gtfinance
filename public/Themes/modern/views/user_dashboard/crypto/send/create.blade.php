@php
    $walletCurrencyCode = strtoupper($walletCurrencyCode);
@endphp

@extends('user_dashboard.layouts.app')

@section('content')

<section class="min-vh-100">
    <div class="my-3">
        <div class="container-fluid">
            <!-- Page title start -->
            <div>
                <h3 class="page-title">@lang('message.dashboard.right-table.crypto-send') {{ $walletCurrencyCode }}</h3>
            </div>
            <!-- Page title end-->

            <div class="mt-5 border-bottom">
                <div class="d-flex flex-wrap">

                    <div class="mr-4 border-bottom-active pb-3">
                        <p class="text-16 font-weight-600 text-active">{{ __('Create') }}</p>
                    </div>

                    <div class="mr-4">
                        <p class="text-16 font-weight-400 text-gray-500"> {{ __('Confirmation') }} </p>
                    </div>

                    <div class="mr-4">
                        <p class="text-16 font-weight-400 text-gray-500">{{ __('Success') }}</p>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-4">
                    <!-- Sub title start -->
                    <div class="mt-5">
                        <h3 class="sub-title">@lang('message.dashboard.right-table.crypto-send') {{ $walletCurrencyCode }}</h3>
                        <p class="text-gray-500 text-16"> {{ __('Enter your recipient  address and amount.') }}</p>
                    </div>
                    <!-- Sub title end-->
                </div>

                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="bg-secondary mt-3 shadow p-35">
                                @include('user_dashboard.layouts.common.alert')

                                <form method="POST" action="{{ url('crpto/send/confirm') }}" id="crypto-send-form" accept-charset='UTF-8'>
                                    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token"/>
                                    <input type="hidden" name="walletCurrencyCode" value="{{ encrypt($walletCurrencyCode) }}"/>
                                    <input type="hidden" name="walletId" value="{{ encrypt($walletId) }}"/>
                                    <input type="hidden" name="senderAddress" value="{{ encrypt($senderAddress) }}"/>

                                    <div>
                                        <!-- Address -->
                                        <div class="form-group">
                                            <label for="receiverAddress">@lang('message.dashboard.crypto.send.create.recipient-address-input-label-text')</label>
                                            <input type="text" class="form-control" value="" name="receiverAddress" id="receiverAddress" placeholder="@lang('message.dashboard.crypto.send.create.recipient-address-input-placeholder-text-1') {{ $walletCurrencyCode }} @lang('message.dashboard.crypto.send.create.recipient-address-input-placeholder-text-2')" onkeyup="this.value = this.value.replace(/\s/g, '')">
                                        </div>

                                        <div class="form-group">
                                            <small class="receiver-address-validation-error text-danger"></small>
                                        </div>


                                        <div class="form-group col-md-12">
                                            <h4 class="font-weight-600 text-16" class="form-text text-muted">*@lang('message.dashboard.crypto.send.create.amount-warning-text-4').</h4>
                                            <small class="form-text text-muted">*@lang('message.dashboard.crypto.send.create.address-qr-code-foot-text-1') {{ $walletCurrencyCode }} @lang('message.dashboard.crypto.receive.address-qr-code-foot-text-2'), @lang('message.dashboard.crypto.receive.address-qr-code-foot-text-3').</small>
                                        </div>

                                        <!-- Amount -->
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">@lang('message.dashboard.send-request.common.amount')</label>
                                            <input type="text" class="form-control amount" name="amount" placeholder="0.00000000" type="text" id="amount" onkeyup="this.value = this.value.replace(/^\.|[^\d\.]/g, '')"
                                            oninput="restrictNumberToEightdecimals(this)"/>
                                            <p class="amount-validation-error text-danger"></p>

                                        </div>

                                        <div class="form-group col-md-12">
                                            @if ($walletCurrencyCode == 'DOGE' || $walletCurrencyCode == 'DOGETEST')
                                                <small class="form-text text-muted">*@lang('message.dashboard.crypto.send.create.amount-warning-text-1') 2 {{ $walletCurrencyCode }}.</small>
                                                <small class="form-text text-muted">*@lang('message.dashboard.crypto.send.create.amount-warning-text-2') 1 {{ $walletCurrencyCode }} @lang('message.dashboard.crypto.send.create.amount-warning-text-3').</small>
                                            @elseif ($walletCurrencyCode == 'BTC' || $walletCurrencyCode == 'BTCTEST')
                                                <small class="form-text text-muted">*@lang('message.dashboard.crypto.send.create.amount-warning-text-1') 0.00002 {{ $walletCurrencyCode }}.</small>
                                                <small class="form-text text-muted">*@lang('message.dashboard.crypto.send.create.amount-warning-text-2') 0.0002 {{ $walletCurrencyCode }} @lang('message.dashboard.crypto.send.create.amount-warning-text-3').</small>
                                            @elseif ($walletCurrencyCode == 'LTC' || $walletCurrencyCode == 'LTCTEST')
                                                <small class="form-text text-muted">*@lang('message.dashboard.crypto.send.create.amount-warning-text-1') 0.0002 {{ $walletCurrencyCode }}.</small>
                                                <small class="form-text text-muted">*@lang('message.dashboard.crypto.send.create.amount-warning-text-2') 0.0001 {{ $walletCurrencyCode }} @lang('message.dashboard.crypto.send.create.amount-warning-text-3').</small>
                                            @endif
                                            <small class="form-text text-muted">*@lang('message.dashboard.crypto.send.create.amount-allowed-decimal-text').</small>
                                        </div>

                                        <div class="mt-1">
                                            <button type="submit" class="btn btn-primary px-4 py-2" id="crypto-send-submit-btn">
                                                <i class="spinner fa fa-spinner fa-spin" style="display: none;"></i> <span id="crypto-send-submit-btn-txt" style="font-weight: bolder;">@lang('message.dashboard.right-table.crypto-send')</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')

<script src="{{ theme_asset('public/js/jquery.validate.min.js') }}" type="text/javascript"></script>

<script src="{{ theme_asset('public/js/sweetalert/sweetalert-unpkg.min.js') }}" type="text/javascript"></script>

<!-- restrictNumberToEightdecimals -->
@include('common.restrict_number_to_eight_decimal')

<script type="text/javascript">
    //Get wallet currency code
    var walletCurrencyCode = '{{ $walletCurrencyCode }}';
    var senderAddress = '{{ $senderAddress }}';
    var receiverAddress;
    var amount;
    var receiverAddressErrorFlag = false;
    var amountErrorFlag = false;
    var receiverAddressValidationError = $('.receiver-address-validation-error');
    var amountValidationError = $('.amount-validation-error');

    /**
    * [check submit button should be disabled or not]
    * return {void}
    */
    function checkSubmitBtn()
    {
        if (!receiverAddressErrorFlag && !amountErrorFlag)
        {
            $("#crypto-send-submit-btn").attr("disabled", false);
        }
        else
        {
            $("#crypto-send-submit-btn").attr("disabled", true);
        }
    }

    /**
    * [Check Address Validity]
    * return promise
    */
    function checkAddressValidity(receiverAddress, walletCurrencyCode)
    {
        return new Promise(function(resolve, reject)
        {
            $.ajax(
            {
                method: "GET",
                url: SITE_URL + "/crpto/send/validate-address",
                dataType: "json",
                data:
                {
                    'receiverAddress': receiverAddress,
                    'walletCurrencyCode': walletCurrencyCode,
                }
            })
            .done(function(res)
            {
                if (res.status != 200)
                {
                    receiverAddressValidationError.text(res.message);
                    receiverAddressErrorFlag = true;
                    checkSubmitBtn();
                }
                else
                {
                    receiverAddressValidationError.text('');
                    receiverAddressErrorFlag = false;
                    checkSubmitBtn();
                }
                resolve(res.status);
            })
            .fail(function(err)
            {
                console.log(err);

                err.responseText.hasOwnProperty('message') == true ? alert(JSON.parse(err.responseText).message) : alert(err.responseText);
                reject(err);
                return false;
            });
        });
    }

    /**
    * [Check Minimum Amount]
    * return {void}
    */
    function checkMinimumAmount(message)
    {
        amountValidationError.text(message);
        receiverAddressErrorFlag = true;
        amountErrorFlag = true;
        checkSubmitBtn();
    }

    /**
    * [Check Amount Validity]
    * return {void}
    */
    function checkAmountValidity(amount, senderAddress, receiverAddress, walletCurrencyCode)
    {
        return new Promise(function(resolve, reject)
        {
            // TODO: translation
            if ((walletCurrencyCode == 'DOGE' || walletCurrencyCode == 'DOGETEST') && amount < 2)
            {
                checkMinimumAmount(`{{ __('The minimum amount must be') }} 2 ${walletCurrencyCode}`)
            }
            else if ((walletCurrencyCode == 'BTC' || walletCurrencyCode == 'BTCTEST') && amount < 0.00002)
            {
                checkMinimumAmount(`{{ __('The minimum amount must be') }} 0.00002 ${walletCurrencyCode}`)
            }
            else if ((walletCurrencyCode == 'LTC' || walletCurrencyCode == 'LTCTEST') && amount < 0.0002)
            {
                checkMinimumAmount(`{{ __('The minimum amount must be') }} 0.0002 ${walletCurrencyCode}`)
            }
            else
            {
                $.ajax(
                {
                    method: "GET",
                    url: SITE_URL + "/crpto/send/validate-user-balance",
                    dataType: "json",
                    data:
                    {
                        'amount': amount,
                        'senderAddress': senderAddress,
                        'receiverAddress': receiverAddress,
                        'walletCurrencyCode': walletCurrencyCode,
                    },
                })
                .done(function(res)
                {
                    if (res.status == 400)
                    {
                        amountValidationError.text(res.message);
                        amountErrorFlag = true;
                        checkSubmitBtn();
                    }
                    else
                    {
                        amountValidationError.text('');
                        amountErrorFlag = false;
                        checkSubmitBtn();
                    }
                    resolve();
                })
                .fail(function(err)
                {
                    console.log(err);

                    err.responseText.hasOwnProperty('message') == true ? alert(JSON.parse(err.responseText).message) : alert(err.responseText);
                    reject(err);
                    return false;
                });
            }
        });
    }

    $(window).on('load', function (e)
    {
        var previousUserCrytoSentUrl = window.localStorage.getItem("previousUserCrytoSentUrl");
        var userConfirmationCryptoSentUrl = SITE_URL+'/crpto/send/confirm';
        var userCryptoSendAmount = window.localStorage.getItem('user-crypto-sent-amount');
        var userCryptoReceiverAddress = window.localStorage.getItem('user-crypto-receiver-address');
        if ((userConfirmationCryptoSentUrl == previousUserCrytoSentUrl) && userCryptoSendAmount != null && userCryptoReceiverAddress != null)
        {
            swal("{{ __('Please Wait') }}", "{{ __('Loading...') }}", {
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: false,
            });

            $('.amount').val(userCryptoSendAmount);
            $('.receiverAddress').val(userCryptoReceiverAddress);

            //Get network fees
            checkAmountValidity($('.amount').val().trim(), senderAddress, $(".receiverAddress").val().trim(), walletCurrencyCode)
            .then(() =>
            {
                $("#crypto-send-submit-btn").attr("disabled", false);
                $(".spinner").hide();
                $("#crypto-send-submit-btn-txt").html("{{ __('Send') }}");
                window.localStorage.removeItem('user-crypto-sent-amount');
                window.localStorage.removeItem('user-crypto-receiver-address');
                window.localStorage.removeItem('previousUserCrytoSentUrl');
                swal.close();
            })
            .catch(error => {
                console.log(error);
            });
        }
    });

    //Validate Address
    $(document).on('blur', ".receiverAddress", function ()
    {
        //Get address
        receiverAddress = $(this).val().trim();
        amount = $('.amount').val().trim();
        if (receiverAddress.length == 0)
        {
            receiverAddressValidationError.text('');
            receiverAddressErrorFlag = false;
            checkSubmitBtn();
        }
        else
        {
            checkAddressValidity(receiverAddress, walletCurrencyCode)
            .then(res =>
            {
                //If amount is not empty and response is 200
                if (amount.length > 0 && !isNaN(amount) && res == 200)
                {
                    checkAmountValidity(amount, senderAddress, receiverAddress, walletCurrencyCode)
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    });

    //Validate Amount
    $(document).on('blur', '.amount', function ()
    {
        //Get amount
        amount = $(this).val().trim();
        receiverAddress = $(".receiverAddress").val().trim();
        if (amount.length > 0 && receiverAddress.length > 0 && !isNaN(amount))
        {
            checkAmountValidity(amount, senderAddress, receiverAddress, walletCurrencyCode).then(res =>
            {
                if (receiverAddress != '' && res == 200)
                {
                    checkAddressValidity(receiverAddress, walletCurrencyCode)
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
        else
        {
            amountValidationError.text('');
            amountErrorFlag = false;
            checkSubmitBtn();
        }
    });

    jQuery.extend(jQuery.validator.messages, {
        required: "{{ __('This field is required.') }}",
        number: "{{ __('Please enter a valid number.') }}",
    })

    $('#crypto-send-form').validate({
        rules: {
            receiverAddress: {
                required: true,
            },
            amount: {
                required: true,
                number: true,
            },
        },
        submitHandler: function (form)
        {
            //Set amount to localstorage for showing on create page on going back from confirm page
            window.localStorage.setItem("user-crypto-sent-amount", $('.amount').val().trim());
            window.localStorage.setItem("user-crypto-receiver-address", $(".receiverAddress").val().trim());

            $(".spinner").show();
            $("#crypto-send-submit-btn").attr("disabled", true);
            $("#crypto-send-submit-btn-txt").text("{{ __('Sending') }}...");
            form.submit();
        }
    });

</script>

@endsection
