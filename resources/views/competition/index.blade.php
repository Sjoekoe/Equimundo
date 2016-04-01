@extends('layout.app')

@section('content')
    <div class="col-sm-12 col-md-8 col-md-offset-2">
        <div class="panel mar-top">
            <div class="panel-bg-cover" style="height: 25em; background-image: url({{ asset('images/jumping-a.png') }})"></div>
        </div>
        <div id="page-title">
            <h1 class="page-header text-overflow">
                Jumping Antwerpen 2016
            </h1>
        </div>
        <div id="page-content">
            <p>
                Van 21 tot en met 24 april 2016 staat de negende editie geprogrammeerd van Jumping Antwerpen.
                Op de terreinen rond de historische kranen aan de Rijnkaai in Antwerpen! Deze unieke locatie wordt voor
                4 dagen omgetoverd tot één van de mooiste en ook meest kwalitatieve outdoorjumpings van ons land.
                Kwaliteit staat immers hoog in het vaandel van de organisatie en dat is dit keer niet anders.
            </p>
            <p>
                Topruiters als o.a. Olympisch kampioen Eric Lamaze, winnaar van de Global Champions Tour 2011 Edwina
                Alexander, wereldkampioen Philippe Lejeune, ex-wereldkampioen Jos Lansink en Belgisch meest succesvolle
                ruiter ooit Ludo Philippaerts hebben ondertussen hun deelname bevestigd. Met 20.000 bezoekers over vier
                dagen, bijna 200 deelnemers (28 nationaliteiten) uit de ganse wereld en 400 paarden is Jumping Antwerpen
                sowieso één van de sportieve ambassadeurs van Stad Antwerpen in de wereld.
            </p>
            <h1><div class="small">Voor elk wat wils</div></h1>
            <p>
                De locatie aan Kaai 28 vlak tegen de Schelde, onder de hallucinante grijparmen van reusachtige kranen,
                is uniek. Niet alleen sportief scoorde Jumping Antwerpen de voorbije edities hoog, maar ook
                organisatorisch was het een schot in de roos! Met een uitgebreid extra sportief programma voor elk wat wils.
            </p>
            <p>
                Toeschouwers zitten op de eerste rij, vlakbij de piste. Sponsoren en genodigden kunnen kiezen tussen
                VIP- en guesttafels of nocturnes; ontmoetingsruimten waar networking centraal staat. Op zaterdagmiddag
                is er een brunch. Uiteraard staan er ’s avonds ook exclusieve optredens op het programma.
                Relatiemarketing is m.a.w. één van de sterkhouders van Jumping Antwerpen.
            </p>

            <jumping></jumping>

            <template id="jumping-form">
                <template v-if="sent">
                    <h1><div class="small">Bedankt voor je deelname. Nu nog duimen of je bij de winaars bent.</div></h1>
                </template>
                <template v-else>
                    <h1><div class="small">Win 3x2 Duo-Tickets</div></h1>
                    <p>
                        Beantwoord volgende vragen en maak kans op 2 duo-tickets op zaterdag 23 April.
                    </p>
                    <label for="q1">Wie was de winnaar van 2015 in de grote prijs op jumping Antwerpen? *</label>
                    <input type="text" v-model="q1" class="form-control">
                    <small class="help-block text-danger text-left" v-if="errors.q1"><i class="fa fa-exclamation-circle"></i> @{{ errors.q1 }}</small>
                    <br>
                    <label for="q2">Welk paard is het populairst op Equimundo? *</label>
                    <input type="text" v-model="q2" class="form-control">
                    <small class="help-block text-danger text-left" v-if="errors.q2"><i class="fa fa-exclamation-circle"></i> @{{ errors.q2 }}</small>
                    <br>
                    <label for="q3">Hoeveel mensen zullen deelnemen aan deze wedstrijd? *</label>
                    <input type="text" v-model="q3" class="form-control">
                    <small class="help-block text-danger text-left" v-if="errors.q3"><i class="fa fa-exclamation-circle"></i> @{{ errors.q3 }}</small>
                    <br>
                    <label for="email">Email *</label>
                    <input type="email" v-model="email" value="{{ auth()->check() ? auth()->user()->email() : '' }}" class="form-control">
                    <small class="help-block text-danger text-left" v-if="errors.email"><i class="fa fa-exclamation-circle"></i> @{{ errors.email }}</small>
                    <br>
                    <label for="name">Naam *</label>
                    <input type="text" v-model="name" value="{{ auth()->check() ? auth()->user()->fullName() : '' }}" class="form-control">
                    <small class="help-block text-danger text-left" v-if="errors.name"><i class="fa fa-exclamation-circle"></i> @{{ errors.name }}</small>
                    <br>
                    <template v-if="submitting">
                        <button class="btn btn-info" disabled><i class="fa fa-spinner fa-spin"></i></button>
                    </template>
                    <template v-else>
                        <button class="btn btn-info" v-on:click="submit">Verzenden</button>
                    </template>
                </template>
            </template>

            <div class="panel mar-top">
                <div class="panel-bg-cover" style="height: 25em; background-image: url({{ asset('images/jumping-a-2.jpg') }})"></div>
            </div>
        </div>
    </div>
@stop
