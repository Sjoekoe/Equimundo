@if ($family->family_id)
    <h4><a href="{{ route('horses.show', $family->originalHorse->slug) }}" class="white-text">{{ $family->family_name }}</a></h4>
@else
    <h4>{{ $family->family_name }}</h4>
@endif
<p>Born: {{ date('Y', strtotime($family->date_of_birth)) }}</p>
<p>Passed Away: {{ $family->date_of_death ? date('Y', strtotime($family->date_of_death)) : '-' }}</p>
<p>Life number: {{ $family->family_life_number ? : '-' }}</p>
