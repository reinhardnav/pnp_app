@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('img/ionline_logo.png') }}" class="" alt="iOnline Logo" style="width: 350px;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
