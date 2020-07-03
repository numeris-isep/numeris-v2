@extends('layouts.file')

@php
  $month = \Carbon\Carbon::parse($payslip->month);
  $to = $month->copy()->lastOfMonth();
  $employee = $payslip->user;
  $mins = (($payslip->hour_amount * 60) % 60);
  $hours = floor($payslip->hour_amount) . 'h' . (string) ($mins == 0 ? '' : $mins);
  $grossAmount = number_format($payslip->gross_amount, 2, '.', '');
  $clients = implode(array_column(json_decode($payslip->clients, true), 'name'), ', ');
  $missions = implode(array_column(json_decode($payslip->operations, true), 'reference'), ', ');
  $dates = implode(array_map(
    function($date) {
      return \Carbon\Carbon::parse($date)->format('d/m/Y');
    },
    array_column(json_decode($payslip->operations, true), 'startAt')
  ), ', ');
@endphp

@section('title')
  Contrat de travail - {{ $employee->getFullName() }} - {{ $month->format('m/Y') }}
@endsection

@section('type')
  Contrat de travail
@endsection

@section('summary')
  <ul class="no-bullet">
    <li>Période d'emploi : du <b>{{ $month->format('d/m/Y') }}</b> au <b>{{ $to->format('d/m/Y') }}</b></li>
    <li>Nombres d'heures travaillées : <b>{{ $hours }}</b></li>
    <li>Rémunération brute : <b>{{ $grossAmount }}€</b></li>
  </ul>
@endsection

@section('header')
  <div class="ui segment information">
    <div class="block third left-aligned">Sociétés : {{ $clients }}</div>
    <div class="block third center-aligned">Opérations : {{ $missions }}</div>
    <div class="block third right-aligned">Dates : {{ $dates }}</div>
  </div>
@endsection

@section('content')
  <h4 class="marged header">Entre les soussignés</h4>
  <div class="text">
    L'association <b>Numéris</b>, association régie à la loi de 1901 est au 28 rue Notre Dame des Champs, 75006 Paris
    représentée par son président Maxime SCHUCHMANN ci-après dénommé "<b>Numéris</b>" d'une part et {{ $employee->getFullName() }},
    demeurant au {{ $employee->address->getFullAddress() }} ci-après dénommé "<b>l'étudiant</b>" d'autre part.
  </div>
  <div class="text">
    L'étudiant et Numéris sont ci-après désignés individuellement une "<b>Partie</b>" et ensemble les "<b>Parties</b>".
  </div>

  <h4 class="marged header">Il a préalablement exposé ce qui suit</h4>
  <div class="text">
    Le présent récapitulatif de mission a pour objet de préciser les termes de la collaboration entre les parties signataires à la
    réalisation de la (des) mission(s) {{ $missions }} confiée(s) par le (les) client(s) {{ $clients }} (ci-après dénomé le
    "<b>Client</b>") à Numéris.
  </div>

  <h4 class="marged header">À la suite de quoi il a été décidé ce qui suit</h4>
  <div class="sub header">Article 1 - Objet de la mission</div>
  <div class="text">
    Cette mission consiste en la déconnexion, la reconnexion, la configuration et la mise en réseau de postes informatiques.
    L’étudiant devra donc mettre en œuvre ses compétences en matière de réseaux et d’informatique pour effectuer cette
    prestation. Il devra également faire preuve d’autonomie et d’organisation pour remplir correctement sa mission.
  </div><br>

  <div class="sub header">Article 2 - Horaires et lieux</div>
  <div class="text">
    Pour remplir sa mission, l’étudiant devra se rendre le jour de la réalisation de la prestation, à l’heure prévue par le
    responsable de mission. Les détails lui seront communiqués par email au plus tard la veille de la mission.
  </div><br>

  <div class="sub header">Article 3 - Indemnisation</div>
  <div class="text">
    Les parties s’accordent que l’indemnisation versée à l’étudiant par Numéris sera de {{ $grossAmount }}€ bruts sur la base
    de {{ $hours }} heures Homme conformément à la législation en vigueur. Cette indemnisation est, toutefois, subordonnée au
    paiement effectif de l’étude par le client.
  </div><br>

  <div class="sub header">Article 4 - Rôle de l'étudiant vis-à-vis de Numéris</div>
  <div class="text">
    L’étudiant mettra en œuvre tous les moyens à sa disposition pour permettre la bonne réalisation de sa mission. Si pour une
    cause quelconque l'étudiant ne pouvait assumer cette mission, il s'engage à en informer immédiatement Numéris afin que
    l’association puisse prendre les dispositions nécessaires au bon accomplissement de ses engagements vis-à-vis de son
    client.
  </div>
@endsection

@section('footer')
  <p class="right-aligned text">
    Fait à Paris, le {{ $month->firstOfMonth()->format('d/m/Y') }} en double exemplaire.
  </p>

  <div class="ui segment">
    <div class="center-aligned half block">
      <div>Pour <b>Numéris</b></div>
      <div>Maxime SCHUCHMANN</div>
      <div class="middle-aligned information">
        <i>lu et approuvé</i>
        <img class="ui mini-tall image" src="{{ public_path('images/signature-maxime-schuchmann.png') }}">
      </div>
    </div>

    <div class="center-aligned half block">
      <div>Pour <b>l'étudiant</b></div>
      <div>{{ $employee->getFullName() }}</div>
    </div>
  </div>
@endsection
