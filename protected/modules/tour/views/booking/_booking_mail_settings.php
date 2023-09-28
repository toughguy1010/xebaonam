<center><b><?= Yii::app()->siteinfo['site_title']; ?> cảm ơn bạn đã đặt tour! Dưới đây là thông tin bạn đã xác nhận trên hệ thống, vui lòng liên hệ với quản trị của chúng tôi thông qua số điện thoại <?= Yii::app()->siteinfo['phone']; ?> nếu xảy ra sai xót!</b></center>
<table>
    <tr>
        <td>Họ và tên: </td> <td><b><?=$model->name?></b></td>
    </tr>
    <tr>
        <td>Địa chỉ: </td> <td><b><?=$model->address?></b></td>
    </tr>
    <tr>
        <td>Số điện thoại: </td> <td><b><?=$model->phone?></b></td>
    </tr>
    <tr>
        <td>Địa điểm du lịch: </td> <td><b><?=TourTouristDestinations::getOptionsDestinations()[$model->places_to_visit]?></b></td>
    </tr>
    <tr>
        <td>Ngày khởi hành: </td> <td><b><?=$model->departure_date?></b></td>
    </tr>
    <tr>
        <td>Số lượng người lớn: </td> <td><b><?=$model->adults?></b></td>
    </tr>
    <tr>
        <td>Số lượng trẻ em: </td> <td><b><?=$model->children?></b></td>
    </tr>
    <tr>
        <td>Độ dài tour: </td> <td><b><?=$model->length?> ngày</b></td>
    </tr>
    <tr>
        <td>Kiểu tour: </td> <td><b><?=TourStyle::model()->findByPk($model->tour_style)->name?></b></td>
    </tr>
    <tr>
        <td>Số hộ chiếu: </td> <td><b><?=$model->passport?></b></td>
    </tr>
    <tr>
        <td>Số máy bay: </td> <td><b><?=$model->flight_number?></b></td>
    </tr>
    <tr>
        <td>Hạng sao khách sạn: </td><td><b><?=TourHotelGroup::getOptionsGroup()[$model->star_rating]?></b></td>
    </tr>
</table>