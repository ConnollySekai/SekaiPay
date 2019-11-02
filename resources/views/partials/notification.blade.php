<div class="notification @if ($invoice) notification--positive @else notification--negative @endif raise rounded mb-2 ">
    <div class="notification__message">
        @if ($invoice)
            <div class="notification__message-icon mr-h">
                <i class="check circle outline icon"></i>
            </div>
            <div class="notification__message-text"><strong class="break-word">{{ request('contract_id') }}</strong> {{ trans('translations.found') }}</div>
        @else 
            <div class="notification__message-icon mr-h">
                <i class="times circle outline icon"></i>
            </div>
            <div class="notification__message-text">{{ trans('translations.must_enter_valid_contract') }}</div>
        @endif
    </div>
    @if ($invoice)
        <div class="notification__action">
            <a href="{{ route('invoice.show',['invoice' => $invoice]) }}" class="ui mini basic positive button button--rounded">{{ trans('translations.view_contract') }}</a>
        </div>
    @endif
    <div class="notification__close">
        <i class="times icon"></i>
    </div>
</div>