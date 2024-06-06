const close_update_for_user = () => {
    window.location.assign("../admin/user_account.php");
}

const close_update_for_subject = () => {
    window.location.assign("../admin/subject.php");
}

const close_update_for_schedule = () => {
    window.location.assign("../admin/schedule.php");
}


function shownewpass() {
    var show = document.getElementById('newpass');
    if(show.type === "password") {
      show.type = "text";
    }
    else {
      show.type = "password";
    }
  }
  function showcurrpass() {
    var show = document.getElementById('currentpass');
    if(show.type === "password") {
      show.type = "text";
    }
    else {
      show.type = "password";
    }
  }
  function showreenterpass() {
    var show = document.getElementById('reenter');
    if(show.type === "password") {
      show.type = "text";
    }
    else {
      show.type = "password";
    }
  }