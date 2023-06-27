@extends('user.layouts.layout')

@section('content')
<!-- profile -->
<div id="profile">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-1">
                <div class="card" style="width: 18rem;">
                    @if ($item && isset($item->photo))
                        <img src="/image/mahasiswa/{{ $item->photo }}" class="card-img-top" alt="...">
                    @endif

                    <div class="card-body text-center">
                        @if ($item && isset($item->nama))
                            <h5 class="card-title">{{ $item->nama }}</h5>
                        @endif

                            @if ($item && isset($item->nrp))
                                <p class="card-text">{{ $item->nrp }}</p>
                            @endif

                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card" style="width: 40rem;">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                              <tr>
                                <td>Tahun Akademik</td>
                                <td>:</td>
                                <td>{{$ta->tahun_akademik}}/{{$ta->semester}}</td>
                              </tr>
                              <tr>
                                <td>Prodi</td>
                                <td>:</td>
                                  @if ($item && isset($item->prodis))
                                      <td>{{ $item->prodis->prodi }}</td>
                                  @endif

                              </tr>
                              <tr>
                                  <td>Kelas</td>
                                  <td>:</td>
                                  @if ($item && isset($item->id_kelas))
                                      @if ($item->id_kelas === null)
                                          <td></td>
                                      @else
                                          <td>{{ $item->kelas->nama }}</td>
                                      @endif
                                  @endif
                              </tr>

                              <tr>
                                  <td>Alamat</td>
                                  <td>:</td>
                                  <td>
                                      @if ($item && isset($item->alamat))
                                          {{ $item->alamat }}
                                      @endif
                                  </td>
                              </tr>

                              <tr>
                                  <td>No HP</td>
                                  <td>:</td>
                                  <td>
                                      @if ($item && isset($item->telp))
                                          {{ $item->telp }}
                                      @endif
                                  </td>
                              </tr>

                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- end profile -->
@endsection
