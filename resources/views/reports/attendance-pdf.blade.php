<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Asistencia</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10px;
            color: #666;
        }
        .filters {
            background-color: #f5f5f5;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .filters h3 {
            font-size: 12px;
            margin-bottom: 5px;
            color: #333;
        }
        .filters p {
            font-size: 9px;
            color: #666;
            margin: 2px 0;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            gap: 10px;
        }
        .stat-card {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .stat-card.blue { background-color: #EFF6FF; border-color: #BFDBFE; }
        .stat-card.green { background-color: #F0FDF4; border-color: #BBF7D0; }
        .stat-card.yellow { background-color: #FEFCE8; border-color: #FDE047; }
        .stat-card.red { background-color: #FEF2F2; border-color: #FECACA; }
        .stat-card.purple { background-color: #FAF5FF; border-color: #E9D5FF; }
        .stat-card h4 {
            font-size: 9px;
            color: #666;
            margin-bottom: 5px;
        }
        .stat-card .number {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .stat-card .percent {
            font-size: 8px;
            color: #666;
            margin-top: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 9px;
        }
        th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #374151;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8px;
            display: inline-block;
        }
        .status-present { background-color: #D1FAE5; color: #065F46; }
        .status-late { background-color: #FEF3C7; color: #92400E; }
        .status-absent { background-color: #FEE2E2; color: #991B1B; }
        .status-justified { background-color: #DBEAFE; color: #1E40AF; }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 REPORTE DE ASISTENCIA</h1>
        <p>Instituto Superior Tecnológico Público - Control de Asistencia</p>
        <p>Generado: {{ $generated_at }}</p>
    </div>

    @if($filters['start_date'] || $filters['end_date'] || $filters['career_id'] || $filters['status'] || $filters['student_id'])
    <div class="filters">
        <h3>🔍 Filtros Aplicados:</h3>
        @if($filters['start_date'])
            <p><strong>Fecha Inicio:</strong> {{ \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') }}</p>
        @endif
        @if($filters['end_date'])
            <p><strong>Fecha Fin:</strong> {{ \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') }}</p>
        @endif
        @if($filters['career_id'])
            <p><strong>Carrera:</strong> Filtrado</p>
        @endif
        @if($filters['status'])
            <p><strong>Estado:</strong> {{ ucfirst($filters['status']) }}</p>
        @endif
        @if($filters['student_id'])
            <p><strong>Estudiante:</strong> Filtrado</p>
        @endif
    </div>
    @endif

    <div class="stats">
        <div class="stat-card blue">
            <h4>Total</h4>
            <div class="number">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card green">
            <h4>Presente</h4>
            <div class="number">{{ $stats['present'] }}</div>
            <div class="percent">{{ $stats['total'] > 0 ? round(($stats['present'] / $stats['total']) * 100) : 0 }}%</div>
        </div>
        <div class="stat-card yellow">
            <h4>Tarde</h4>
            <div class="number">{{ $stats['late'] }}</div>
            <div class="percent">{{ $stats['total'] > 0 ? round(($stats['late'] / $stats['total']) * 100) : 0 }}%</div>
        </div>
        <div class="stat-card red">
            <h4>Ausente</h4>
            <div class="number">{{ $stats['absent'] }}</div>
            <div class="percent">{{ $stats['total'] > 0 ? round(($stats['absent'] / $stats['total']) * 100) : 0 }}%</div>
        </div>
        <div class="stat-card purple">
            <h4>Justificado</h4>
            <div class="number">{{ $stats['justified'] }}</div>
            <div class="percent">{{ $stats['total'] > 0 ? round(($stats['justified'] / $stats['total']) * 100) : 0 }}%</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">Estudiante</th>
                <th style="width: 10%;">DNI</th>
                <th style="width: 10%;">Código</th>
                <th style="width: 20%;">Carrera</th>
                <th style="width: 10%;">Fecha</th>
                <th style="width: 8%;">Hora</th>
                <th style="width: 10%;">Estado</th>
                <th style="width: 7%;">Fuente</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record['student_name'] }}</td>
                <td>{{ $record['student_dni'] }}</td>
                <td>{{ $record['student_code'] }}</td>
                <td>{{ $record['career'] }}</td>
                <td>{{ $record['date_formatted'] }}</td>
                <td>{{ $record['time'] }}</td>
                <td>
                    @php
                        $statusLabels = [
                            'present' => 'Presente',
                            'absent' => 'Ausente',
                            'late' => 'Tarde',
                            'justified' => 'Justificado',
                        ];
                        $statusClass = 'status-' . $record['status'];
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        {{ $statusLabels[$record['status']] ?? $record['status'] }}
                    </span>
                </td>
                <td style="text-align: center;">
                    @php
                        $sourceEmoji = $record['source'] === 'public' ? '🌐' : ($record['source'] === 'gate' ? '🚪' : '✍️');
                    @endphp
                    {{ $sourceEmoji }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte generado automáticamente por el Sistema de Control de Asistencia</p>
        <p>Total de registros: {{ $stats['total'] }} | Página 1 de 1</p>
    </div>
</body>
</html>
