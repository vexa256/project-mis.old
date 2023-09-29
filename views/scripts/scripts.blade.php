<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}">
</script>

<script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}">
</script>


@isset($editor)
<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>


<script src="{{ asset('assets/ckeditor/adapters/jquery.js') }}"></script>

<script>
    $(document).ready(function() {
        $('textarea').ckeditor(function(textarea) {
            // Callback function code.
        });
    });

</script>
@endisset


@isset($chart)
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $chart->script() !!}



@isset($charts)
{!! $charts->script() !!}
@endisset
@endisset


@isset($FinancialQuarterChart)
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $FinancialQuarterChart->script() !!}
@endisset


@isset($ModuleChart)
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $ModuleChart->script() !!}
@endisset

@include('not.not')
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>



@if (isset($rem))
<script>
    $(function() {
        setInterval(function() {
            @foreach($rem as $val)
            console.log(".x_{{ $val }}");
            $(".x_{{ $val }}").remove();
            @endforeach
        }, 1000);



    });

</script>
@endif
</body>


</html>
