$(document).ready(function() {
  $("[name=comments]").each(function(index, element) {
    postId = $(element).attr('id').split('-')[1];
    if ($(this).children().length==0) {
      $("#getComments-"+postId).hide();
    }  
  })
});

$(function() {
  // Удаление комментария
  $(document).on('click', "[name=deleteComm]", function(){
    commId = $(this).attr('id').split('-')[1];
    $.ajax({url: "./comments/delete",
      data: {'comment': {'id' : commId}},
        success: function(){
          if ($("#comments-"+postId).children().length<3) {
            $("#getComments-"+postId).hide();
          }
          $("div[name=comment-"+commId+"]").remove();  
          $("#comments-"+postId).children().last().show(); 
          },
          type: "POST"
    });
  });

  // Загрузка, показ и сокрытие предыдущих
  $("[name=load]").click(function(){
    postId = $(this).attr('id').split('-')[1];
    switch ($(this).attr('act')) {
      case 'get':
        $.ajax({
              url: "./comments/get",
              data: {'post_id': postId},
              success: function(response){
                  $("#getComments-"+postId).html('Скрыть комментарии');
                  $("div[id=comments-"+postId+"]").children().remove();
                  $("div[id=comments-"+postId+"]").prepend(response);
                  if ($("#comments-"+postId).children().length<2) {
                    $("#getComments-"+postId).hide();
                  }   
               },
              type: "GET"
            });
        $(this).attr('act', 'hide');
      break
      case 'hide':
        $("#comments-"+postId).children().hide();
        $("#comments-"+postId).children().last().show();
        $(this).attr('act', 'show');
        $("#getComments-"+postId).html('Показать комментарии');
      break
      case 'show':
        $("#comments-"+postId).children().show();
        $(this).attr('act', 'hide');
        $("#getComments-"+postId).html('Скрыть комментарии');
      break
    }
  });

  // Добавление комментария
  $("[name=addComm]").click(function() {
    
    postId = $(this).attr('id').split('-')[1];
    text = $("#commText-"+postId).val();
    if (text=='') {
      exit;
    }
    $.ajax({url: "./comments/add",
      data: {'comment': {'post_id' : postId, 'text' : text}},
        success: function(response){
          $("#getComments-"+postId).show();
          $("div[id=comments-"+postId+"]").append(response);
          $("#commText-"+postId).val('');
          },
          type: "POST"
    });
  });
});
