<form action="/user/type" method="POST">
    {{ csrf_field() }}
    <input type="text" name="id">
    <input type="text" name="user_type">
    <input type="submit" value="送出表單">
</form>