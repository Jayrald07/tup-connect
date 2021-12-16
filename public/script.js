var Data = function (prev, current, next) {
	this.prev = prev;
	this.current = current;
	this.next = next;
};

var DoublyLinkedList = function (data_arr) {
	this.data = (function () {
		let arr = [];
		for (let i = 0; i < data_arr.length; i++) {
			if (i === 0) arr[i] = new Data(null, data_arr[i], data_arr[i + 1]);
			else if (i === data_arr - 1)
				arr[i] = new Data(data_arr[i - 1], data_arr[i], null);
			else arr[i] = new Data(data_arr[i - 1], data_arr[i], data_arr[i + 1]);
		}
		return arr;
	})();
	this.length = this.data.length;
	this.top = 0;
	this.current_node = function () {
		return this.data[this.top];
	};
	this.next = function () {
		if (this.top + 1 < this.length) {
			++this.top;
			return this.data[this.top];
		}
	};
	this.prev = function () {
		if (this.top - 1 > -1) {
			--this.top;
			return this.data[this.top];
		}
	};
};

var ui = (function () {
	let input_email = document.getElementById("reg-email");
	let regpass = document.getElementById("reg-password");
	let regconfirmpass = document.getElementById("reg-confirm-password");
	let basicprofile = document.getElementById("basic-profile-id");
	let inputcode = document.getElementsByClassName("input-code-box");
	let post_option = document.getElementsByClassName("post-option")[0];
	let post_option_toggle =
		document.getElementsByClassName("post-option-toggle");
	let comment = document.getElementsByClassName("comment");
	let comment_modal = document.getElementsByClassName("comment-modal")[0];
	let comment_modal_close = document.getElementsByClassName(
		"comment-modal-close"
	)[0];
	let post_button = document.getElementsByClassName("post-button")[0];
	let post_modal_close = document.getElementsByClassName("post-modal-close")[0];
	let post_modal = document.getElementsByClassName("post-modal")[0];
	let comment_input = document.getElementById("comment-input");
	let comment_button = document.getElementById("comment-button");
	let comment_body = document.getElementsByClassName("comment-body")[0];
	let up_vote = document.getElementsByClassName("up-vote");
	let down_vote = document.getElementsByClassName("down-vote");
	let report_post = document.getElementById("report-post");
	let report_user = document.getElementById("report-user");
	let report_modal = document.getElementsByClassName("report-modal")[0];
	let report_modal_close = document.getElementById("report-modal-close");
	let report_submit = document.getElementById("report-submit");
	let report_desc = document.getElementsByClassName("report-desc");
	let post_delete = document.getElementById("delete-post");
	let delete_modal = document.getElementsByClassName("delete-modal")[0];
	let delete_cancel = document.getElementById("delete-cancel");
	let delete_delete = document.getElementById("delete-delete");
	let user_based = document.getElementsByClassName("user-based");
	let edit_post = document.getElementById("edit-post");
	let post_image_container = document.getElementById("post-image-container");
	let v2_modal = document.getElementsByClassName("v2-modal")[0];
	let v2_modal_close = document.getElementsByClassName("v2-modal-close")[0];
	let post_image_add = document.getElementById("post-image-add");
	let post_update_submit = document.getElementById("post-update-submit");
	let elms = document.getElementsByClassName("splide");
	let block_user = document.getElementById("block-user");
	let user_based_block = document.getElementById("user-based-block");

	return {
		input_email,
		regpass,
		regconfirmpass,
		basicprofile,
		inputcode,
		post_option,
		post_option_toggle,
		comment,
		comment_modal,
		comment_modal_close,
		post_button,
		post_modal_close,
		post_modal,
		comment_input,
		comment_button,
		comment_body,
		up_vote,
		down_vote,
		report_post,
		report_user,
		report_modal,
		report_modal_close,
		report_submit,
		report_desc,
		post_delete,
		delete_modal,
		delete_cancel,
		delete_delete,
		user_based,
		edit_post,
		post_image_container,
		v2_modal,
		v2_modal_close,
		post_image_delete() {
			return document.getElementsByClassName("post-image-delete");
		},
		post_image_add,
		post_update_submit,
		elms,
		block_user,
		user_based_block,
	};
})();

var controller = (function (_UI) {
	const tup_email_parser = /\w+([a-z])\.\w+([a-z])@tup.edu.ph/;
	let is_basic_good = false;
	let is_password_good = false;
	let boxes;
	let comment_post_id;
	let report_post_id = null;
	let report_user_id = null;
	let report_type = null;
	let report_description = null;
	let selected_image_deletion = [];

	return {
		init() {
			_UI.input_email.addEventListener("keyup", function (e) {
				if (!tup_email_parser.test(this.value)) {
					this.classList.add("error-input");
					is_basic_good = false;
				} else {
					is_basic_good = true;
					this.classList.remove("error-input");
				}
			});
			_UI.regconfirmpass.addEventListener("keyup", function (e) {
				console.log(this.value);
				if (this.value.trim() !== _UI.regpass.value.trim()) {
					this.classList.add("error-input");
					_UI.regpass.classList.add("error-input");
					is_password_good = false;
				} else {
					this.classList.remove("error-input");
					_UI.regpass.classList.remove("error-input");
					is_password_good = true;
				}
			});
			_UI.basicprofile.addEventListener("submit", function (e) {
				if (!is_basic_good || !is_password_good) e.preventDefault();
			});
		},
		verify() {
			boxes = new DoublyLinkedList(_UI.inputcode);
			for (let i = 0; i < _UI.inputcode.length; i++) {
				_UI.inputcode[i].addEventListener("click", function (e) {
					boxes.current_node().current.focus();
				});
				_UI.inputcode[i].addEventListener("keyup", function (e) {
					if (e.keyCode !== 8) boxes.next()?.current.focus();
					else boxes.prev()?.current.focus();
				});
			}
		},
		async vote(post_id, type) {
			try {
				let result = await $.ajax({
					url: "http://localhost/tup-connect/index.php/post/vote",
					type: "POST",
					dataType: "json",
					data: {
						post_id: post_id,
						vote_type: type,
					},
				});
				return result;
			} catch (e) {
				new Error(e);
			}
		},
		report() {
			report_type = this.type;
			_UI.report_modal.style.display = "flex";
			_UI.post_option.style.display = "none";
		},
		open_user_based(value) {
			for (let i = 0; i < _UI.user_based.length; i++) {
				_UI.user_based[i].style.display = value;
				if (value === "block") _UI.block_user.style.display = "none";
				else _UI.block_user.style.display = "block";
			}
		},
		image_delete() {
			const _ = this;
			for (let i = 0; i < _UI.post_image_delete().length; i++) {
				_UI.post_image_delete()[i].addEventListener("click", function (e) {
					_.toggle_deleted_image(this.getAttribute("x-value"));
					if (e.target.localName === "i")
						e.target.parentElement.parentElement.classList.toggle(
							"selected-delete"
						);
					else e.target.parentElement.classList.toggle("selected-delete");
				});
			}
		},
		toggle_deleted_image(post_image_id) {
			if (selected_image_deletion.includes(post_image_id)) {
				selected_image_deletion = selected_image_deletion.filter((item) => {
					return item !== post_image_id;
				});
			} else selected_image_deletion.push(post_image_id);
		},
		posts_init() {
			for (let i = 0; i < _UI.post_option_toggle.length; i++) {
				_UI.post_option_toggle[i].addEventListener("click", function (e) {
					_UI.post_option.style.left = e.target.offsetLeft - 110 + "px";
					_UI.post_option.style.top = e.target.offsetTop - 10 + "px";
					report_post_id = this.getAttribute("post-value");
					report_user_id = this.getAttribute("user-value");

					$.ajax({
						url: "http://localhost/tup-connect/index.php/post/is_delete",
						type: "POST",
						dataType: "text",
						data: {
							user_detail_id: report_user_id,
						},
						success: function (data) {
							if (data == 1) controller.open_user_based("block");
							else controller.open_user_based("none");
							_UI.post_option.style.display =
								_UI.post_option.style.display === "block" ? "none" : "block";
						},
						error: function (data) {
							console.log(data);
						},
					});
				});
				_UI.comment[i].addEventListener("click", function (e) {
					_UI.comment_modal.style.display = "block";
					comment_post_id = this.getAttribute("x-value");
					_UI.comment_body.textContent = null;
					$.ajax({
						url: "http://localhost/tup-connect/index.php/comment/get",
						type: "POST",
						dataType: "json",
						data: { "post-id": comment_post_id },
						success: function (data) {
							console.log(data);
							if (data.length) {
								data.forEach((item) => {
									_UI.comment_body.insertAdjacentHTML(
										"afterbegin",
										`
										<section class="comment-section">
                    <div class="comment-section-header">
                        <figure>
                            <img src="http://localhost/tup-connect/public/assets/user.png" />
                        </figure>
                        <div>
                            <h1>${item.first_name} ${item.last_name}</h1>
                            <time>${item.date_time_stamp}</time>
                        </div>
                        <a href="#">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                    </div>
                    <div class="comment-section-body">
                        <p>
                            ${item.comment_text}
                        </p>
                    </div>
                    <div class="comment-section-footer">
                        <a href="#">
                            <i class="fas fa-reply"></i>
                        </a>
                        <a href="#">
                            <i class="fas fa-comment"></i>
                        </a>
                    </div>
                </section>
									`
									);
								});
							} else
								_UI.comment_body.innerHTML =
									"<p align='center'><small>No Comment</small></p>";
						},
						error: function (data) {
							console.log(data.responseText);
						},
					});
				});
				_UI.comment_modal_close.addEventListener("click", (e) => {
					_UI.comment_modal.style.display = "none";
				});

				_UI.up_vote[i].addEventListener("click", async () => {
					let res = await this.vote(
						_UI.up_vote[i].getAttribute("x-value"),
						"up"
					);
					if (res.length) {
						_UI.up_vote[i].children[1].textContent = res[0].post_up_vote;
						_UI.down_vote[i].children[1].textContent = res[0].post_down_vote;
					}
				});
				_UI.down_vote[i].addEventListener("click", async () => {
					let res = await this.vote(
						_UI.down_vote[i].getAttribute("x-value"),
						"down"
					);
					if (res.length) {
						_UI.up_vote[i].children[1].textContent = res[0].post_up_vote;
						_UI.down_vote[i].children[1].textContent = res[0].post_down_vote;
					}
				});
			}

			for (let i = 0; i < _UI.report_desc.length; i++) {
				_UI.report_desc[i].addEventListener("click", function (e) {
					report_description = this.getAttribute("x-value");
				});
			}

			for (var i = 0; i < _UI.elms.length; i++) {
				new Splide(_UI.elms[i], {
					type: "loop",
				}).mount();
			}

			_UI.post_button.addEventListener("click", () => {
				_UI.post_modal.style.display = "flex";
				CKEDITOR.instances["post-content"].setData("");
			});
			_UI.post_modal_close.addEventListener("click", () => {
				_UI.post_modal.style.display = "none";
				_UI.post_image_container.textContent = "";
			});
			_UI.v2_modal_close.addEventListener("click", () => {
				_UI.v2_modal.style.display = "none";
				_UI.post_image_container.textContent = "";
			});
			_UI.comment_button.addEventListener("click", () => {
				$.ajax({
					url: "http://localhost/tup-connect/index.php/comment/insert",
					type: "POST",
					dataType: "text",
					data: {
						comment: _UI.comment_input.value.trim(),
						"post-id": comment_post_id,
					},
					success: function (data) {
						if (data) location.reload();
					},
					error: function (data) {
						console.log(data.responseText);
					},
				});
			});
			_UI.report_post.addEventListener(
				"click",
				this.report.bind({ type: "post" })
			);
			_UI.report_user.addEventListener(
				"click",
				this.report.bind({ type: "user" })
			);
			_UI.report_modal_close.addEventListener("click", () => {
				_UI.report_modal.style.display = "none";
			});
			_UI.report_submit.addEventListener("click", (e) => {
				let props = null;
				if (report_type === "post") {
					props = {
						post_id: report_post_id,
						user_detail_id: report_user_id,
						report_description: report_description,
						url: "report",
					};
				} else if (report_type === "user") {
					props = {
						user_detail_id: report_user_id,
						report_description: report_description,
						url: "user_report",
					};
				} else if (report_type === "block") {
					props = {
						user_detail_id: report_user_id,
						block_description: report_description,
						url: "block_user",
					};
				}

				$.ajax({
					url: `http://localhost/tup-connect/index.php/post/${props.url}`,
					type: "POST",
					dataType: "text",
					data: props,
					success: function (data) {
						if (data === "success") location.reload();
					},
					error: function (data) {
						console.log(data);
					},
				});
			});
			_UI.post_delete.addEventListener(
				"click",
				(e) => (_UI.delete_modal.style.display = "flex")
			);
			_UI.delete_cancel.addEventListener(
				"click",
				(e) => (_UI.delete_modal.style.display = "none")
			);
			_UI.delete_delete.addEventListener("click", (e) => {
				$.ajax({
					url: "http://localhost/tup-connect/index.php/post/delete",
					type: "POST",
					dataType: "text",
					data: {
						post_id: report_post_id,
					},
					success: function (data) {
						if (data === "success") location.reload();
					},
					error: function (data) {
						console.log(data);
					},
				});
			});
			_UI.edit_post.addEventListener("click", (e) => {
				_UI.post_image_container.textContent = "";
				_UI.post_option.style.display = "none";
				$.ajax({
					url: "http://localhost/tup-connect/index.php/post/getone",
					type: "POST",
					dataType: "json",
					data: {
						post_id: report_post_id,
					},
					success: (data) => {
						if (data.length) {
							selected_image_deletion = [];
							_UI.v2_modal.style.display = "flex";
							CKEDITOR.instances["post-content-edit"].setData(
								data[0].post_text
							);
							if (data[0].post_image_path) {
								for (let i = 0; i < data[0].post_image_path.length; i++) {
									let { post_image_path, post_image_id } =
										data[0].post_image_path[i];
									_UI.post_image_container.insertAdjacentHTML(
										"afterbegin",
										`<div class="image-container">
								<a href="javascript:void(0)" x-value=${post_image_id} class="post-image-delete"><i class="fas fa-trash"></i></a>
								<img src="http://localhost/tup-connect/uploads/${post_image_path}" />
								</div>
							`
									);
								}
								this.image_delete();
							}
						}
					},
					error: function (data) {
						console.log(data);
					},
				});
			});
			_UI.post_update_submit.addEventListener("click", () => {
				console.log(_UI.post_image_add.files);
				let data = new FormData();
				let images = [];
				data.append("post_id", report_post_id);
				data.append(
					"post_text",
					CKEDITOR.instances["post-content-edit"].getData()
				);
				data.append("post_image_ids_delete", selected_image_deletion);

				for (let i = 0; i < _UI.post_image_add.files.length; i++)
					data.append("post_image_add[]", _UI.post_image_add.files[i]);

				$.ajax({
					url: "http://localhost/tup-connect/index.php/post/update",
					type: "POST",
					dataType: "text",
					data,
					processData: false,
					contentType: false,
					success: function (data) {
						if (data === "success") location.reload();
						else alert("There's a problem editing the post.");
					},
					error: function (data) {
						console.log(data.responseText, "asd");
					},
				});
			});
			_UI.block_user.addEventListener("click", function (e) {
				report_type = "block";
				_UI.report_modal.style.display = "flex";
				_UI.post_option.style.display = "none";
			});
		},
	};
})(ui);
