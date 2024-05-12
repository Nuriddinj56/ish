<?PHP
$mytemp = $this->pdo->query("SELECT * FROM `smstemp` ORDER by id DESC");
$mytemp = $mytemp->fetchAll();
if (empty($mytemp)): ?>
		<h6>Шаблонов пока нет</h6>
<?php else:
foreach ($mytemp as $key => $value):
$bank = $this->pdo->query("SELECT * FROM banks WHERE id = '".$value['bank']."'");
$bank = $bank->fetch(PDO::FETCH_ASSOC);
?>
<div class="transactions-list t-info">
<div class="t-item">
<div class="t-company-name">
<div class="t-icon">
<div class="avatar avatar-xl">
<img class="" width="55" src="<? echo $bank['logo_card'];?>" alt="">
</div>
</div>
<div class="t-name">
<h4><a href="#" data-toggle="modal" data-target="#exampleModalShablon<? echo $value['id'];?>"><? echo $value['name'];?></a></h4>
<?

$ident = 'Порт: '.$value['port'];	

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
                                    <div class="modal fade" id="exampleModalShablon<? echo $value['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Просмотр шаблона</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                        <p class="modal-text"><b>Текст смс:</b><br><? echo $value['text'];?><br>
														<b>Сумма:</b> <? echo $value['summa'];?><br>
														<b>Баланс:</b> <? echo $value['balance'];?><br>
														<b>Порт:</b> <? echo $value['port'];?></p>
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
				url: "/delsmstemp/" + id + "/",
				method: 'GET',
				data: {id:id},
				cache: false,
				success: function(html){
					Snackbar.show({
                text: 'Шаблон успешо удалён',
		        showAction: false,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a'
                });
				show();
				}
			});
		 });
		 </script>