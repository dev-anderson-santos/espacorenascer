@extends('adminlte::page')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Agenda</h1>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-body">
        <div class="alert alert-secondary" style="font-size: 15pt" role="alert">
            <i class="fas fa-info-circle"></i> Para realizar um agendamento, clique em um horário <b>Livre</b>.
        </div>
        <form action="{{ route('schedule.show-specific-shedule') }}" method="post" class="form-group">
            @csrf
            <div class="form-row">
                <div class="col-md-4">
                    <label for="">Data:</label>
                    <select class="form-control" name="day" id="data-agendamento" onchange="$(this).parents('form').submit()"">
                        <option value="">-- Selecione --</option>
                        @foreach ($dataSelect as $d)
                        <option value="{{ $d->format('Y-m-d') }}" {{ !empty($_day) && $_day == $d->format('Y-m-d') ? 'selected' : '' }}>{{ $d->isoFormat('dddd, DD \d\e MMMM \d\e Y') }} </option>
                        @endforeach
                    </select>
                </div>
            </div>            
        </form>
        @if (!empty($showSpecificShedule))
            <table class="table table-bordered table-striped table-sm" id="schedule-table" style="width:100%">
                <thead>
                    <tr>
                        <th style="text-align: center" scope="col"></th>
                        <th style="text-align: center" scope="col">Sala 101</th>
                        <th style="text-align: center" scope="col">Sala 102</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hours as $hour)
                        <tr>
                            <td style="text-align: center">{{ \Carbon\Carbon::parse($hour->hour)->format('H') }}h</td>
                            @foreach ($rooms as $room)                                 
                                <td style="text-align: center">
                                    @if ($hour->hour < \Carbon\Carbon::now()->format('H:i:s') && $_day == \Carbon\Carbon::now()->format('Y-m-d'))
                                        Indisponível
                                    @else
                                        <a href="javascript:void(0)" onclick="modalGlobalOpen('{{ route('schedule.modal-schedule', ['room_id' => $room->id, 'hour_id' => $hour->id, 'user_id' => auth()->user()->id, 'data' => $_day]) }}', 'Agendamento')">
                                        @php
                                            $schedule = \App\Models\ScheduleModel::where('hour_id', $hour->id)->get();
                                        @endphp
                                        @if(count($schedule) > 0 && !empty($schedule[$loop->index]))
                                            @if ($schedule[$loop->index]->date == $_day && $schedule[$loop->index]->room_id == $room->id)
                                                {{ $schedule[$loop->index]->user->name }} 
                                            @else
                                                Livre
                                            @endif
                                        @else
                                            Livre
                                        @endif
                                        </a>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection