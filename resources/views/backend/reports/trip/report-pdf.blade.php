<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report Trip {{ $request->from_date }} / {{ $request->until_date}}</title>
  <style>
      .page-break-before{page-break-before: always;}
      .clearfix { clear: both !important;  }
      .header .info{
        float: left;
      }
      .header .info .title{
        font-size: 22px;
        line-height: 10px;
        margin-top: -5px;
      }
      .header .info .permission{
        font-size: 16px;
        margin-top: -8px;
      }
      .header .info .address{
        margin-top: -10px;
      }
      .separator{ 
        display: block;
        width: 100%;
        border-bottom: 1px solid #000; 
        margin-top: 40px;
      }

      .table-detail{
          display: block;
          width: 100%;
          margin-top: 30px;
      }
      .table-detail .table-title{ width: 100%; }
      .table-detail .table-title p{ margin-top: -5px; font-size: 20px; text-align: center; }
      .table-detail .filter{ margin-top: 10px; margin-bottom: 10px; font-size: 15px; }
      .table-detail table{ width: 100%; }
      .table-detail table th{ padding: 10px 5px; }
      .table-detail table td{ padding: 10px; }
      .table-detail table th,
      .table-detail table td{ font-size: 12px; }

      .badge-success{ color: #28a745; }
      .badge-primary{ color: #696cff; }
      .badge-warning{ color: #ffc107; }
      .badge-danger{ color: #dc3545; }
  </style>
</head>
<body>
  <div class="header">
    <div class="info">
      <h1 class="title">Green Village</h1>
      <p class="address">
        Jl. Tanah Ayu, Sibang Gede, Kec. Abiansemal, Kabupaten Badung, Bali
      </p>
    </div>
  </div>
  <div class="separator"></div>

  <div class="table-detail">
    <div class="table-title">
      <p style="font-size: 16px;"><b>Report Trip</b></p>
    </div>
    <div class="filter">
      @if ($request->status != '')
        <b>Status: </b>
        @if ($request->status == 'done')
          <span class="badge-success">Done</span>
        @elseif ($request->status == 'on-progress')
          <span class="badge-primary">On Progress</span>
        @elseif ($request->status == 'active')
          <span class="badge-primary">Active</span>
        @elseif ($request->status == 'pending')
          <span class="badge-warning">Pending</span>
        @else
          <span class="badge-danger">Cancel</span>
        @endif
      @endif
      @if($request->from_date != '' && $request->until_date != '')
        <br>
        <b>Tgl: </b> <?= date("d/m/Y", strtotime($request->from_date)); ?> s/d <?= date("d/m/Y", strtotime($request->until_date)); ?>
      @endif
    </div>
    <table rules="all" cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th><b>No</b></th>
          <th>Trip Name</th>
          <th>Type</th>
          <th>Date Activity</th>
          <th>Departure Time</th>
          <th>Driver</th>
          <th>Status</th>
          <th>Created By</th>
        </tr>
      </thead>
      <tbody>
        @php $no = 0; @endphp
        @foreach ($getDatas as $key => $item)
          @php $no += 1; @endphp
          <tr>
            <td class="text-center">{{ $no }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ isset($item->re_type_trip) ? $item->re_type_trip->name : '-' }}</td>
            <td>
              {{ \Carbon\Carbon::parse($item->from_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->until_date)->format('d/m/Y') }}
            </td>
            <td>{{ \Carbon\Carbon::parse($item->departure_time)->format('g:i A') }}</td>
            <td>{{ isset($item->re_driver) ? $item->re_driver->name : '' }}</td>
            <td>
              @if ($item->status == 'done')
                <span class="badge-success">Done</span>
              @elseif ($item->status == 'on-progress')
                <span class="badge-primary">On Progress</span>
              @elseif ($item->status == 'active')
                <span class="badge-primary">Active</span>
              @elseif ($item->status == 'pending')
                <span class="badge-warning">Pending</span>
              @else
                <span class="badge-danger">Cancel</span>
              @endif
            </td>
            <td>{{ isset($item->re_created_by) ? $item->re_created_by->name : '' }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>
</html>
