@extends('layouts.file')

@php
  $month = \Carbon\Carbon::parse($payslip->month);
  $to = $month->copy()->lastOfMonth();
  $employee = $payslip->user;
  $mins = (($payslip->hour_amount * 60) % 60);
  $hours = floor($payslip->hour_amount) . 'h' . (string) ($mins == 0 ? '' : $mins);
  $grossAmount = number_format($payslip->gross_amount, 2, '.', '');
  $netAmount = number_format($payslip->net_amount, 2, '.', '');
  $subscriptionFee = number_format($payslip->subscription_fee, 2, '.', '');
  $finalAmount = number_format($payslip->final_amount, 2, '.', '');
  $deductions = json_decode($payslip->deductions, true);
  $employeeDeductionAmount = number_format($payslip->deduction_amount, 2, '.', '');
  $employerDeductionAmount = number_format($payslip->employer_deduction_amount, 2, '.', '');
  $clients = implode(array_column(json_decode($payslip->clients, true), 'name'), ', ');
  $missions = implode(array_column(json_decode($payslip->operations, true), 'reference'), ', ');
  $dates = implode(array_map(
    function($date) {
      return \Carbon\Carbon::parse($date)->format('d/m/Y');
    },
    array_column(json_decode($payslip->operations, true), 'startAt')
  ), ', ');
@endphp

@section('style')
  <link type="text/css" rel="stylesheet" href="{{ base_path('resources/assets/css/semantic/table.min.css') }}" />
@endsection

@section('title')
  Bulletin de versement - {{ $employee->getFullName() }} - {{ $month->format('m/Y') }}
@endsection

@section('type')
  Bulletin de versement
@endsection

@section('summary')
  <ul class="no-bullet">
    <li>Période d'emploi : du <b>{{ $month->format('d/m/Y') }}</b> au <b>{{ $to->format('d/m/Y') }}</b></li>
    <li>Nombres d'heures travaillées : <b>{{ $hours }}</b></li>
    <li>Rémunération brute : <b>{{ $grossAmount }}€</b></li>
  </ul>
@endsection

@section('header')
  <div class="ui segments">
    <div class="ui segment">
      <div class="block half">
        <h2 class="header">Employeur</h2>
        <ul class="information no-bullet">
          <li>Association Numéris ISEP</li>
          <li>M Maxime SCHUCHMANN</li>
          <li>28 rue Notre Dame des Champs, 75006 Paris</li>
          <li>Code NAF : 9499Z</li>
          <li>N° employeur : 117000001559324700</li>
          <li>SIRET : 822 976 106 00010</li>
          <li>URSSAF Île-de-France</li>
        </ul>
      </div>

      <div class="block half">
        <h2 class="header">Salarié</h2>
        <ul class="information no-bullet">
          <li>{{ $employee->getFullName() }}</li>
          <li>N° de sécurité sociale : {{ $employee->social_insurance_number }}</li>
          <li>Date de naissance : {{ \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') }}</li>
          <li>Lieu de naissance : {{ $employee->birth_city }}</li>
          <li>Convention collective : Aucune CCN - Droit du travail</li>
          <li>Emploi occupé : Technicien informatique</li>
        </ul>
      </div>
    </div>

    <div class="ui segment information">
      <div class="block third left-aligned">Sociétés : {{ $clients }}</div>
      <div class="block third center-aligned">Opérations : {{ $missions }}</div>
      <div class="block third right-aligned">Dates : {{ $dates }}</div>
    </div>
  </div>
@endsection

@section('content')
  <table class="ui celled very compact structured table">
    <thead>
    <tr>
      <th rowspan="2">Cotisations et contributions</th>
      <th rowspan="2">Base</th>
      <th colspan="2">Part salariale</th>
      <th colspan="2">Part employeur</th>
    </tr>
    <tr>
      <th>Taux</th>
      <th>Montant</th>
      <th>Taux</th>
      <th>Montant</th>
    </tr>
    </thead>

    <tbody class="center aligned">
      @foreach($deductions as $deduction)
        @php
          $base = number_format($deduction['base'], 2, '.', '');
          $employeeRate = $deduction['employeeRate'] != 0 ? number_format($deduction['employeeRate'], 2, '.', '') : '-';
          $employerRate = $deduction['employerRate'] != 0 ? number_format($deduction['employerRate'], 2, '.', '') : '-';
          $employeeAmount = $deduction['employeeAmount'] != 0 ? number_format($deduction['employeeAmount'], 2, '.', '') : '-';
          $employerAmount = $deduction['employerAmount'] != 0 ? number_format($deduction['employerAmount'], 2, '.', '') : '-';
        @endphp
        <tr>
          <td>{{ $deduction['socialContribution'] }}</td>
          <td>{{ $base }}</td>
          <td>{{ $employeeRate }}</td>
          <td>{{ $employeeAmount }}</td>
          <td>{{ $employerRate }}</td>
          <td>{{ $employerAmount }}</td>
        </tr>
      @endforeach
    </tbody>

    <tfoot class="center aligned">
      <tr>
        <th colspan="2"><b>Montant total des cotisations retenues</b></th>
        <th colspan="2">{{ $employeeDeductionAmount }}€</th>
        <th colspan="2">{{ $employerDeductionAmount }}€</th>
      </tr>
      </tfoot>
  </table>

  <div class="block half">
    <table class="ui celled very compact structured grey table">
      <tbody>
        <tr>
          <td class="hightlight">Rémunération brute</td>
          <td class="center aligned">{{ $grossAmount }}</td>
        </tr>
        <tr>
          <td class="hightlight">Total cotisations</td>
          <td class="center aligned">{{ $employeeDeductionAmount }}</td>
        </tr>
        <tr>
          <td class="hightlight">Cotisation Numéris</td>
          <td class="center aligned">{{ $subscriptionFee }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="block half">
    <table class="ui celled very compact structured grey table">
      <tbody>
        <tr>
          <td class="hightlight">Rémunération nette imposable</td>
          <td class="center aligned">{{ $netAmount }}</td>
        </tr>
        <tr>
          <td class="hightlight">Total net à verser</td>
          <td class="center aligned"><b>{{ $finalAmount }}€</b></td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection

@section('footer')
  <p class="right-aligned text">
    Fait à Paris, le {{ $month->firstOfMonth()->format('d/m/Y') }}.
  </p>

  <p class="center-aligned information">
    Les bulletins de versement sont à conserver sans limitation de durée (loi 86-966 du 16/08/1986).
    Ils sont succeptibles de vous être demandés lors d'un contrôle de votre situation fiscale.
  </p>
@endsection
