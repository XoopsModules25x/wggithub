<{if $navigation|default:'' || $buttons|default:''}>
    <div class='top'>
        <span class='left'><{$navigation|default:''}></span>
        <{if isset($buttons)}>
            <span class='left'><{$buttons}></span>
        <{/if}>
    </div>
<{/if}>
