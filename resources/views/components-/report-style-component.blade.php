<style>
    /* {{-- CBC Style --}}  */
    table,
    th,
    td {
        border: 1px solid #e7e7e7;
        border-collapse: collapse;
        height: 15px;
        color: #000;
        text-align: center;
    }

    .pos {
        margin-left: 20px !important;
        border: 1px solid #ddd;
        text-align: center;
        margin-bottom: 0px;
        font-size:16px;
        width: 50px;
    }

    td {
        border: 1px solid #e7e7e7;
        padding: 2px;
        text-align: center;
        color: #000;
    }

    .pinfo {
        border-collapse: collapse;
        border-radius: 10px;
        height: 20px;
        text-align: center;
        width: 100%;
        color: #000;
    }

    .theadcbc {
        border: 1px solid #e7e7e7;
        background-color: #b4e4f7;
        color: #00658c;
        font-weight: bold;
        font-size: 14px;
        height: 20px;
        text-align: center;
    }

    .relativeh {
        border: 1px solid #e7e7e7;
        background-color: #b4e4f7;
        color: #00658c;
        font-weight: bold;
        font-size: 14px;
        height: 20px;
    }

    .absolutetd {
        border: 1px solid #e7e7e7;
        background-color: #b4e4f7;
        color: #00658c;
        font-weight: bold;
        font-size: 14px;
        height: 20px;
        width: 100%;
    }

    .tleft {
        float: left;
        width: 57%;
        padding-bottom: 10px;
        text-align: center;
    }

    .tright {
        float: right;
        width: 42%;
        padding-bottom: 10px;
        text-align: center;
    }

    .tleftcbc {
        float: left;
        width: 70%;
        padding-bottom: 10px;
        text-align: center;
    }

    .test_title {
        font-family: {{ setting('reports')['test_title']['font-family'] }} !important;
    }

    .test_name {
        font-family: {{ setting('reports')['test_name']['font-family'] }} !important;
    }

    .test_head {
        font-family: {{ setting('reports')['test_head']['font-family'] }} !important;
    }

    .result {
        font-family: {{ setting('reports')['result']['font-family'] }} !important;
    }

    .unit {
        font-family: {{ setting('reports')['unit']['font-family'] }} !important;
    }

    .reference_range {
        font-family: {{ setting('reports')['reference_range']['font-family'] }} !important;
    }

    .status {
        font-family: {{ setting('reports')['status']['font-family'] }} !important;
    }

    .tleftcbc_noFig {
        float: left;
        width: 100%;
        padding-bottom: 10px;
        text-align: center;
    }

    .trightcbc {
        float: right;
        width: 29%;
        padding-bottom: 10px;
        text-align: center;
    }

    {{-- another test Style --}} .ttable {
        width: 100% !important;
    }

    .ttable thead {
        background-color: red !important;
    }

    .testtable {
        border: 1px solid #e7e7e7;

        border-collapse: collapse;
        height: 20px;
        width: 100%;
        text-align: center;
    }

    span {
        content: "\2191";
    }

    .tdtest {
        /* background-color: #FFF; */
        padding-left: 15px;
        height: 20px;
        font-size: 14px;
        text-align: left;
    }

    .tdtest_background {
        background-color: #FFF;
    }

    .tdtest_status {
        background-color: #f4f4f4;
    }

    .theadtest {
        border: 1px solid #e7e7e7;
        color: #000 !important;
        font-weight: bold;
        font-size: 14px;
        height: 20px;
        text-align: center;
        min-width: fit-content !important;
    }

    .ttitle {
        background-color: #f4f4f4;
        font-weight: 600;
        text-align: center;
    }

    .tsthead {
        color: #00658c;
        text-align: left;
        text-decoration: underline;
    }

    .category_title {
        color: #000;
        text-align: center;
        margin-top: 20px;
        text-decoration: underline;
    }

    .category_title_ray {
        color: #000;
        text-align: center;
        font-family: cairo !important;
    }

    .comment {
        padding: 5px;
        text-align: left;
        font-size: 14px;
    }

    .commentb {
        padding: 5px;
        text-align: left;
        font-size: 14px;
    }

    {{--  Simens Style  --}} .tablesemen {
        width: 100%;
        border: 0px solid #b3adad;
        padding: 1px;
        font-size: 14px;
        margin: 0px;
    }

    .tablesemen th {
        border: 0px solid #b3adad;
        font-size: 14px;
        padding: 1px;
        margin: 0px;
        color: #313030;
    }

    .theadsemen {
        font-size: 14px;
    }

    .tablesemen td {
        border: 0px solid #b3adad;
        font-size: 14px;
        text-align: left;
        padding: 1px;
        margin: 0px;
        color: #313030;
    }

    .borderd {
        border: 1px solid #b3adad;
        text-align: center;
    }

    .borderd-left {
        border: 1px solid #b3adad;
        text-align: left;
    }

    .colored {
        border: 1px solid #b3adad;
        text-align: center;
        color: #313030;
    }

    .table_inside {
        border: 0px solid #fff;
        width: 100%;
        padding: 0px;
    }

    .table_left {
        float: left;
        width: 40%;
        padding: 0px;
    }

    .table_right {
        float: right;
        width: 45%;
        padding: 0px;
    }

    .headleft {
        width: 15%;
        float: left;
    }

    .tableculture {
        width: 100%;
        border: 1px solid #b3adad;
        border-collapse: collapse;
        padding: 5px;
    }

    .tableculture th {
        border: 1px solid #b3adad;
        padding: 5px;
        background: #f0f0f0;
        color: #313030;
    }

    .tableculture td {
        border: 1px solid #b3adad;
        text-align: center;
        padding: 5px;
        background: #ffffff;
        color: #313030;
    }
</style>
