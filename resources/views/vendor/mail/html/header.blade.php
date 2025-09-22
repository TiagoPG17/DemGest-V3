@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
@if (trim($slot) === 'Laravel' || trim($slot) === 'GHconnecting')
<div style="text-align: center;">
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-radius: 16px; padding: 16px; display: inline-block; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); margin-bottom: 8px;">
        <div style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 12px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-weight: bold; font-size: 24px; color: white; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
            GH
        </div>
    </div>
    <div style="color: #ffffff; font-size: 28px; font-weight: 700; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); margin-top: 8px;">
        GHconnecting
    </div>
    <div style="color: rgba(255, 255, 255, 0.9); font-size: 14px; font-weight: 400; margin-top: 4px;">
        Demo Application
    </div>
</div>
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
