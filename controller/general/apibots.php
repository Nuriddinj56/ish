<? include './template/template_header.tpl'; 
if (empty($_SESSION['user_id'])):
header('Location: /auth/');
exit;
endif;
$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
$insertSql->execute([
    'user_id' => $_SESSION['user_id'],
    'text' => 'В разделе боты автопродаж',
    'date' => time()
    ]);
?>

<?PHP
$mytemp = $this->pdo->query("SELECT * FROM `bots` ORDER by id DESC");
$mytemp = $mytemp->fetchAll();
if (empty($mytemp)): ?>
		<h6>Вы ещё не добавляли ботов</h6>
<?php else:
foreach ($mytemp as $key => $value):
$bank = $this->pdo->query("SELECT * FROM banks WHERE id = '".$value['bank']."'");
$bank = $bank->fetch(PDO::FETCH_ASSOC);
?>
<div class="transactions-list t-info">
<div class="t-item">
<div class="t-company-name">
<div class="t-name">
<h4><a href="#" data-toggle="modal" data-target="#exampleModalCenter<? echo $value['id'];?>"><? echo $value['name'];?></a></h4>
<?

$ident = $value['username'];	

?>
<p class="meta-date"><? echo $ident;?></p>
</div>
</div>
<div class="t-rate rate-inc">
<p><span><a href="#" class="button_del" onclick="return false" id="<? echo $value['id'];?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a></span></p>
</div>
</div>
</div>
 
                                
                                

                                    

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter<? echo $value['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Просмотр бота</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                        <p class="modal-text" style="font-size:12px;"><b>Токен бота:</b><br><? echo $value['token'];?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Закрыть окно</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                      
<?PHP
endforeach;
?>
<?php endif; ?>


    <script>
	$(".button_del").click(function() {					
   var id = this.id;
			$.ajax({
				url: "/delsbot/" + id + "/",
				method: 'GET',
				data: {id:id},
				cache: false,
				success: function(html){
					Snackbar.show({
                text: 'Бот успешо удалён',
		        showAction: false,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a'
                });
				apibotsshow();
				}
			});
		 });
		 </script>