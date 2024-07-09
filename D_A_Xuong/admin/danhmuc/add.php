<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <h1 class="text-center">Thêm sản phẩm mới</h1>
            <div class="card mt-3">
                <div class="card-body">
                    <form action="index.php?act=adddm" method="post">
                        <div class="form-group">
                            <label for="maloai">Mã loại</label>
                            <!-- disabled Tự tăng -->
                            <input type="text" id="maloai" name="maloai" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="tenloai">Tên loại</label>
                            <input type="text" id="tenloai" name="tenloai" class="form-control">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="themmoi" class="btn btn-primary">THÊM MỚI</button>
                            <button type="reset" class="btn btn-primary">NHẬP LẠI</button>
                            <a href="index.php?act=danhmuc" class="btn btn-secondary">DANH SÁCH</a>
                        </div>
                        <?php
                        if(isset($thongbao)&&($thongbao != ""))  {
                            echo $thongbao;
                        }
                       
                        // if (isset($thongbao) && $thongbao != "") {
                        //     echo "<div class='alert alert-success text-center mt-3'>$thongbao</div>";
                        // }
                        ?>
                    </form>
                </div>
            </div>      
        </div>
    </div>
</div>
<br>