<footer class="main-footer">
    <div class="row">
        <div class="col">
            <small><strong>© Copyright {{ \Carbon\Carbon::now()->format('Y') }} - <a class="text-reset fw-bold" href="#">{{ config('app.name')}}</a></strong></small>
        </div>
        @php
            $stringfromfile = file('../.git/HEAD', FILE_USE_INCLUDE_PATH);
            $firstLine = $stringfromfile[0]; //get the string from the array
            $explodedstring = explode("/", $firstLine, 3); //seperate out by the "/" in the string
            $branchname = trim($explodedstring[2]);
        @endphp
        {{-- <div class="col">
            <div class="text-center">
                <span style="font-size: 10px">{{ $branchname }}</span>
            </div>
        </div> --}}
        <div class="col text-right">
            <div class="pull-right hiden-xs">
                @php
                    $version = explode('release-v', $branchname);
                @endphp
                <small><b>Versão</b> {{ $version[1] ?? '1.0' }}</small>
            </div>
        </div>
    </div>
</footer>