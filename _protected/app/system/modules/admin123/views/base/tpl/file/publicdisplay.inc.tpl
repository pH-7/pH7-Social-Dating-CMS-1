<div class="center">

{@if(!empty($filesList))@}
<ul>

  {@foreach($filesList as $file)@}
    {{ $short_path = str_replace(PH7_PATH_ROOT, '', $file) }}
    <li><a href="{{ $design->url(PH7_ADMIN_MOD, 'file', 'publicedit', $short_path, false) }}" title="{@lang('Click for display/edit this file')@}">{short_path}</a></li>
  {@/foreach@}

</ul>

{@else@}

  <p>{@lang('Not Found Templates Files.')@}</p>

{@/if@}

</div>
