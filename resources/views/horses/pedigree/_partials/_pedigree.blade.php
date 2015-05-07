<h4>{{ $family->family_name }}</h4>
<p>Born: {{ date('Y', strtotime($family->date_of_birth)) }}</p>
<p>Passed Away: {{ $family->date_of_death ? date('Y', strtotime($family->date_of_death)) : '-' }}</p>
<p>{{ $family->family_life_number }}</p>
