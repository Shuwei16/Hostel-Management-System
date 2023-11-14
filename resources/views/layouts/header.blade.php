<style>
    /* Header CSS */
    header {
        font-family: verdana, sans-serif;
    }
    .header-deco1{
        background-color: #FB9D58;
        height: 10px;
        margin-top: 0;
    }
    .header-content {
        width: 100%;
    }
    .header-content td {
        text-align: center;
        padding: 0 10px 0 10px;
    }
    .header-content img {
        width: 200px;
        vertical-align: middle;
    }
    .header-content span {
        font-size: 4.5vmin;
        padding: 0;
        margin: 0;
        vertical-align: middle;
        font-weight: bold;
    }
    .header-content button {
        font-family: verdana, sans-serif;
        background-color: #F9C03D;
        color: white;
        border: none;
        border-radius: 7px;
        width: 150px;
        padding: 10px 10px;
        transition: 0.5s;
    }
    .header-content button:hover {
        background-color: #facf6b;
        cursor: pointer;
    }
    .header-deco2{
        background-color: #293952;
        height: 2px;
    }
</style>
<header>
    <!-- Header content -->
    <p class="header-deco1"><p>
    <table class="header-content">
        <tr>
            <td style="text-align: left;">
                <a href="/"><img src="{{ asset('images/tarumt-logo.png') }}" alt="Logo" ><a>
                <span>Hostel</span>
            </td>
            <td style="text-align: right;">
                <button type="button" onclick="window.location.href = 'login';">Sign In</button>
            </td>
        </tr>
    </table>
    <div class="header-deco2"><div>
</header>