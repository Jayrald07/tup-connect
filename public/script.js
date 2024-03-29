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
		post_image_add,
		post_update_submit,
		elms,
		block_user,
		user_based_block,
		post_image_delete() {
			return document.getElementsByClassName("post-image-delete");
		},
		getId(id) {
			return document.getElementById(id);
		},
		getClass(class_name) {
			return document.getElementsByClassName(class_name);
		},
	};
})();

var controller = (function (_UI) {
	const tup_email_parser = /\w+([a-z])\w+([a-z])@tup.edu.ph/;
	let is_basic_good = false;
	let is_password_good = false;
	let boxes;
	let comment_post_id;
	let report_post_id = null;
	let report_user_id = null;
	let report_type = null;
	let report_description = null;
	let selected_image_deletion = [];
	let search_categories = [];
	let delete_member_id = null;
	let group_id = null;
	let bulk_group_user_update = [];
	let bulk_post_reported = [];
	let delete_role_id = null;
	let current_role_id = null;
	let current_comments = [];
	let is_replying = false;
	let select_comment_id = null;
	let hovered_comment_id = null;
	let is_hovered_comment_reply = false;
	let under_the_comment_of = null;
	let org_id = null;
	let ninja_ = false;

	return {
		init() {
			_UI.getId("college")?.addEventListener("change", function () {
				ninja_ = true;
				let courses = _UI.getClass("course-option");
				for (let i = 0; i < courses.length; i++) {
					if (courses[i].getAttribute("x-ref") !== this.value)
						courses[i].hidden = true;
					else {
						courses[i].hidden = false;
					}
				}
				_UI.getId("course").value = null;
			});

			_UI.input_email?.addEventListener("keyup", function (e) {
				if (!tup_email_parser.test(this.value)) {
					this.classList.add("error-input");
					is_basic_good = false;
				} else {
					is_basic_good = true;
					this.classList.remove("error-input");
				}
			});
			_UI.regconfirmpass?.addEventListener("keyup", function (e) {
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
			_UI.basicprofile?.addEventListener("submit", function (e) {
				if (!is_basic_good || !is_password_good)
					if (!ninja_) e.preventDefault();
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
					url: `${base_url}/post/vote`,
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
		join_group_event() {
			let elm = _UI.getClass("search-group-join");
			let _ = this;
			for (let i = 0; i < elm.length; i++) {
				_UI
					.getClass("join-trigger")
					?.[i]?.addEventListener("click", function () {
						$.ajax({
							url: `${base_url}/join_group`,
							type: "POST",
							dataType: "text",
							data: {
								group_id: this.getAttribute("x-value"),
							},
							success: (data) => {
								if (data) _.search_group();
							},
							error: (data) => console.log(data),
						});
					});

				_UI
					.getClass("cancel-group-trigger")
					?.[i]?.addEventListener("click", function () {
						$.ajax({
							url: `${base_url}/cancel_group_request`,
							type: "POST",
							dataType: "text",
							data: {
								group_id: this.getAttribute("x-value"),
							},
							success: (data) => {
								if (data) _.search_group();
							},
							error: (data) => console.log(data),
						});
					});
			}
		},
		join_org_event() {
			let elm = _UI.getClass("search-org-join");
			let _ = this;
			for (let i = 0; i < elm.length; i++) {
				_UI
					.getClass("join-org-trigger")
					?.[i]?.addEventListener("click", function () {
						$.ajax({
							url: `${base_url}/join_org`,
							type: "POST",
							dataType: "text",
							data: {
								organization_id: this.getAttribute("x-value"),
							},
							success: (data) => {
								if (data) _.search_org();
							},
							error: (data) => console.log(data),
						});
					});

				_UI
					.getClass("cancel-org-trigger")
					?.[i]?.addEventListener("click", function () {
						$.ajax({
							url: `${base_url}/cancel_org_request`,
							type: "POST",
							dataType: "text",
							data: {
								organization_id: this.getAttribute("x-value"),
							},
							success: (data) => {
								console.log(data);
								if (data) _.search_org();
							},
							error: (data) => console.log(data),
						});
					});
			}
		},
		join_action(data) {
			if (data.is_owner) {
				return (
					`<a href="${base_url}/groups/` +
					data.group_id +
					'" class="search-group-join" >View</a>'
				);
			} else {
				console.log(data.status);
				if (data.status === -1 || data.status == 2) {
					return (
						'<a href="javascript:void(0)" class="search-group-join join-trigger" x-value="' +
						data.group_id +
						'" >Join</a>'
					);
				} else {
					return (
						'<a href="javascript:void(0)" class="search-group-join cancel-group-trigger" x-value="' +
						data.group_id +
						'" >Cancel Requested</a>'
					);
				}
			}
		},
		join_org_action(data) {
			if (data.is_owner) {
				return (
					`<a href="${base_url}/organizations/` +
					data.organization_id +
					'" class="search-org-join" >View</a>'
				);
			} else {
				console.log(data.status);
				if (data.status === -1 || data.status == 2) {
					return (
						'<a href="javascript:void(0)" class="search-org-join join-org-trigger" x-value="' +
						data.organization_id +
						'" >Join</a>'
					);
				} else {
					return (
						'<a href="javascript:void(0)" class="search-org-join cancel-org-trigger" x-value="' +
						data.organization_id +
						'" >Cancel Requested</a>'
					);
				}
			}
		},
		search_group() {
			_UI.getClass("search-result-container")[0].textContent = null;

			if (
				_UI.getId("group-name").value.trim() == false &&
				search_categories.length == 0
			) {
				_UI
					.getClass("search-result-container")[0]
					.insertAdjacentHTML("afterbegin", `<h1>No Groups</h1>`);
			} else {
				_UI.getClass("search-result-container")[0].textContent = null;
				$.ajax({
					url: `${base_url}/search_group`,
					type: "POST",
					dataType: "json",
					data: {
						group_name: _UI.getId("group-name").value,
						categories: search_categories,
					},
					success: (data) => {
						_UI.getClass("search-result-container")[0].textContent = null;

						if (data.length) {
							for (let i = 0; i < data.length; i++) {
								_UI.getClass("search-result-container")[0].insertAdjacentHTML(
									"afterbegin",
									`
									<div class="search-group-card">
										<section>
											<h1>${data[i].group_name}</h1>
											<small>Members: <span>${data[i].members}</span></small>
										</section>
										${this.join_action(data[i])}
									</div>
								`
								);
							}
							this.join_group_event();
						} else {
							_UI.getClass("search-result-container")[0].insertAdjacentHTML(
								"afterbegin",
								`
									<h1>No Groups</h1>
								`
							);
						}
					},
					error: function (data) {
						console.log(data);
					},
				});
			}
		},
		register_reply_event() {
			const reply_button = _UI.getClass("reply");
			for (let i = 0; i < reply_button.length; i++) {
				reply_button[i].addEventListener("click", function () {
					is_replying = true;
					let [selected_comment] = current_comments.filter((item) => {
						if (item.comment_id == this.getAttribute("x-value")) return item;
					});
					select_comment_id = selected_comment.comment_id;
					_UI.getClass("reply-container")[0].textContent = null;
					_UI.getClass("reply-container")[0].insertAdjacentHTML(
						"afterbegin",
						`
						<div class="replying-to">
							<h1>Replying to ${selected_comment.first_name} ${selected_comment.last_name}</h1>
							<p>${selected_comment.comment_text}</p>
						</div>
						<a href="javascript:void(0)" class="close-reply" x-value="${selected_comment.comment_id}">
							<i class="fas fa-times"></i>
						</a>
					`
					);
					_UI.getClass("close-reply")[0].addEventListener("click", () => {
						is_replying = false;
						_UI.getClass("reply-container")[0].textContent = null;
					});
				});
			}
		},
		register_comment_event() {
			window.addEventListener("click", () => {
				_UI.getClass("comment-option")[0].style.display = "none";
			});
			for (let i = 0; i < _UI.getClass("comment-menu").length; i++) {
				_UI.getClass("comment-menu")[i].addEventListener("click", function (e) {
					e.stopPropagation();
					is_hovered_comment_reply =
						this.getAttribute("x-type") === "reply" ? true : false;
					hovered_comment_id = this.getAttribute("x-value");
					under_the_comment_of = this.getAttribute("x-under");
					_UI.getClass("comment-option")[0].style.display = "block";
					_UI.getClass("comment-option")[0].style.left = e.screenX - 80 + "px";
					_UI.getClass("comment-option")[0].style.top =
						e.target.offsetTop + "px";
				});
			}
		},
		edit_comment_event() {
			let [comment_found] = current_comments.filter((item) => {
				if (!is_hovered_comment_reply) {
					if (item.comment_id === hovered_comment_id) return true;
				} else {
					if (item.comment_id === under_the_comment_of) return true;
				}
				return false;
			});

			if (is_hovered_comment_reply) {
				comment_found = comment_found.replies.filter((item) => {
					if (item.comment_id === hovered_comment_id) return true;
					else return false;
				});
				[comment_found] = comment_found;
			}

			console.log(is_hovered_comment_reply);

			_UI.getId("comment-input").value = comment_found.comment_text;
			_UI.getId("comment-button").style.display = "none";
			_UI.getId("comment-button-update").style.display = "block";

			_UI.getClass("reply-container")[0].textContent = null;
			_UI.getClass("reply-container")[0].insertAdjacentHTML(
				"afterbegin",
				`
						<div class="replying-to" id="edit-container">
							<h1>Editing your comment...</h1>
						</div>
						<a href="javascript:void(0)" class="close-reply" id="close-edit" x-value="${comment_found.comment_id}">
							<i class="fas fa-times"></i>
						</a>
					`
			);
			_UI.getId("close-edit").addEventListener("click", () => {
				_UI.getClass("reply-container")[0].textContent = null;
				_UI.getId("comment-input").value = "";
				_UI.getId("comment-button").style.display = "block";
				_UI.getId("comment-button-update").style.display = "none";
			});
		},
		search_org() {
			_UI.getClass("org-result-container")[0].textContent = null;
			console.log(
				_UI.getId("search-use-org-type").checked,
				_UI.getId("search-org-type").value,
				_UI.getId("search-college-select").value
			);
			if (
				_UI.getId("search-org-name").value.trim() == false &&
				search_categories.length == 0
			) {
				_UI
					.getClass("org-result-container")[0]
					.insertAdjacentHTML("afterbegin", `<h1>No Organization</h1>`);
			} else {
				_UI.getClass("org-result-container")[0].textContent = null;
				$.ajax({
					url: `${base_url}/find_org`,
					type: "POST",
					dataType: "json",
					data: {
						org_name: _UI.getId("search-org-name").value,
						use_org_type: _UI.getId("search-use-org-type").checked ? 1 : 0,
						org_type: _UI.getId("search-org-type").value,
						college_id: _UI.getId("search-college-select").value,
						interests: search_categories,
					},
					success: (data) => {
						_UI.getClass("org-result-container")[0].textContent = null;
						console.log(data);
						if (data.length) {
							for (let i = 0; i < data.length; i++) {
								_UI.getClass("org-result-container")[0].insertAdjacentHTML(
									"afterbegin",
									`
									<div class="search-group-card">
										<section>
											<h1>${data[i].organization_name}</h1>
											 <small>Members: <span>${data[i].members}</span></small>
										</section>
										${this.join_org_action(data[i])}
									</div>
								`
								);
							}
							this.join_org_event();
						} else {
							_UI.getClass("org-result-container")[0].insertAdjacentHTML(
								"afterbegin",
								`
									<h1>No Organization</h1>
								`
							);
						}
					},
					error: function (data) {
						console.log(data);
					},
				});
			}
		},
		posts_init() {
			let _ = this;

			_UI.getId("explore-now")?.addEventListener("click", () => {
				_UI.getClass("welcome-modal")[0].style.display = "none";
			});

			_UI.getId("announcement-group")?.addEventListener("click", () => {
				_UI.getId("announcement-container").style.display = "block";
				_UI.getId("non-announcement-container").style.display = "none";
			});

			_UI.getId("announcement-org")?.addEventListener("click", () => {
				_UI.getId("announcement-container").style.display = "block";
				_UI.getId("non-announcement-container").style.display = "none";
			});

			_UI.getId("back-non")?.addEventListener("click", () => {
				_UI.getId("announcement-container").style.display = "none";
				_UI.getId("non-announcement-container").style.display = "block";
			});

			_UI
				.getClass("delete-comment-cancel")[0]
				?.addEventListener("click", function () {
					_UI.getClass("delete-comment-modal")[0].style.display = "none";
				});

			_UI
				.getClass("delete-post-cancel")[0]
				?.addEventListener("click", function () {
					console.log("as");
					_UI.getClass("delete-post-modal")[0].style.display = "none";
				});

			_UI.getId("search-org-close").addEventListener("click", () => {
				_UI.getClass("search-org-modal")[0].style.display = "none";
			});

			_UI.getId("search-org-name").addEventListener("keyup", () => {
				this.search_org();
			});

			_UI.getId("search-use-org-type").addEventListener("change", () => {
				this.search_org();
			});

			_UI.getId("search-org-type").addEventListener("change", () => {
				if (_UI.getId("search-use-org-type").checked) this.search_org();
			});

			_UI.getId("search-college-select").addEventListener("change", () => {
				if (_UI.getId("search-use-org-type").checked) this.search_org();
			});

			let org_interest = _UI.getClass("search-org-interest");

			for (let i = 0; i < org_interest.length; i++) {
				org_interest[i].addEventListener("change", function () {
					console.log("VAL:", this.getAttribute("x-value"));
					if (search_categories.indexOf(this.getAttribute("x-value")) > -1) {
						search_categories = search_categories.filter((item) => {
							return item === this.getAttribute("x-value") ? false : true;
						});
						console.log(search_categories);
					} else search_categories.push(this.getAttribute("x-value"));
					console.log("val", search_categories);
					_.search_org();
				});
			}

			_UI.getId("search-org-trigger")?.addEventListener("click", () => {
				_UI.getClass("search-org-modal")[0].style.display = "flex";
			});

			_UI.getId("search-org-type").addEventListener("change", function () {
				let status = "none";
				if (this.value === "college") status = "block";
				else status = "none";
				_UI.getId("search-college-select").style.display = status;
				_UI.getId("search-college-label").style.display = status;
			});

			_UI.getId("org-type").addEventListener("change", function () {
				if (this.value === "college") {
					_UI.getId("college-select").style.display = "block";
					_UI.getId("college-label").style.display = "block";
				} else {
					_UI.getId("college-select").style.display = "none";
					_UI.getId("college-label").style.display = "none";
				}
			});

			_UI.getId("create-org-trigger")?.addEventListener("click", () => {
				_UI.getClass("org-modal")[0].style.display = "flex";
			});

			_UI.getId("create-org-close").addEventListener("click", () => {
				_UI.getClass("org-modal")[0].style.display = "none";
			});

			_UI.getId("delete-comment").addEventListener("click", () => {
				console.log(hovered_comment_id);
				_UI.getClass("delete-comment-modal")[0].style.display = "flex";
				_UI.getClass("delete-comment-modal")[0].style.zIndex =
					"99999999999999999";
			});

			_UI.getId("comment-button-update").addEventListener("click", () => {
				let comment_text = _UI.getId("comment-input");
				if (String(comment_text.value).trim().length) {
					$.ajax({
						url: `${base_url}/update_comment`,
						type: "POST",
						dataType: "text",
						data: {
							comment_id: hovered_comment_id,
							value: comment_text.value,
						},
						success: (data) => {
							if (parseInt(data)) location.reload();
						},
						error: (data) => {
							console.log(data);
						},
					});
				} else comment_text.value = "";
			});

			_UI.getId("edit-comment").addEventListener("click", () => {
				this.edit_comment_event();
			});

			_UI.getId("delete-comment-delete").addEventListener("click", () => {
				$.ajax({
					url: `${base_url}/delete_comment`,
					type: "POST",
					dataType: "text",
					data: {
						id: hovered_comment_id,
						type: is_hovered_comment_reply ? "reply" : "comment",
					},
					success: function (data) {
						if (parseInt(data)) location.reload();
						else alert("Deleting Error! Please try again.");
					},
					error: function (data) {
						console.log(data);
					},
				});
			});

			_UI.getClass("post-modal-upload")[0].addEventListener("click", () => {
				_UI.getId("post-modal-files").click();
			});

			_UI.getId("post-modal-files").addEventListener("change", function () {
				_UI.getId("upload-details").textContent =
					this.files.length + " picture/s";
			});

			for (let i = 0; i < _UI.post_option_toggle.length; i++) {
				_UI.post_option_toggle[i].addEventListener("click", function (e) {
					console.log(e);
					_UI.post_option.style.left = e.pageX - 110 + "px";
					_UI.post_option.style.top = e.pageY - 10 + "px";
					report_post_id = this.getAttribute("post-value");
					report_user_id = this.getAttribute("user-value");

					$.ajax({
						url: `${base_url}/post/is_delete`,
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
				_UI.comment[i]?.addEventListener("click", function (e) {
					_UI.comment_modal.style.display = "block";
					comment_post_id = this.getAttribute("x-value");
					_UI.comment_body.textContent = null;
					console.log(comment_post_id);
					$.ajax({
						url: `${base_url}/comment/get`,
						type: "POST",
						dataType: "json",
						data: { "post-id": comment_post_id },
						success: function (data) {
							console.log(data);
							current_comments = data;
							if (data.length) {
								data.forEach((item) => {
									const val = item.image_path.split(".");
									let path = "uploads/";

									if (val[0] === "user-1") path = "public/assets/";
									if (item.status === "deleted") {
										_UI.comment_body.insertAdjacentHTML(
											"afterbegin",
											`<section style="padding: 10px;text-align:center" class="comment-section" id="${item.comment_id}"><small>Deleted</small></section>`
										);
									} else {
										_UI.comment_body.insertAdjacentHTML(
											"afterbegin",
											`
											<section class="comment-section" id="${item.comment_id}">
												<div class="comment-section-header">
													<figure>
														<img src="${base_url}/${path}${item.image_path}" />
													</figure>
													<div>
														<h1>${item.first_name} ${item.last_name}</h1>
														<time class="timeago" datetime="${item.date_time_stamp}">${
												item.date_time_stamp
											}</time>
													</div>
													${
														item.is_own
															? `<a href="javascript:void(0)" x-type="comment" class="comment-menu" x-value="${item.comment_id}"><i class="fas fa-ellipsis-v"></i></a>`
															: ""
													}
												</div>
												<div class="comment-section-body">
													<p>
														${item.comment_text}
													</p>
												</div>
												<div class="comment-section-footer">
													<a href="javascript:void(0)" class="reply" x-value="${item.comment_id}">
														<i class="fas fa-reply"></i>
													</a>
												</div>
											</section>
										`
										);
									}
									item.replies.forEach((reply) => {
										const val = reply.image_path.split(".");
										let path = "uploads/";

										if (val[0] === "user-1") path = "public/assets/";
										console.log(reply);
										if (reply.status === "deleted_reply") {
											_UI.getId(item.comment_id).insertAdjacentHTML(
												"afterend",
												`
											<section style="padding: 10px;text-align:center" class="comment-section reply-card"><small>Deleted</small></section>`
											);
										} else {
											_UI.getId(item.comment_id).insertAdjacentHTML(
												"afterend",
												`
											<section class="comment-section reply-card">
												<div class="comment-section-header">
													<figure>
														<img src="${base_url}/${path}${reply.image_path}" />
													</figure>
													<div>
														<h1>${reply.first_name} ${reply.last_name}</h1>
														<time  class="timeago" datetime="${reply.date_time_stamp}">${
													reply.date_time_stamp
												}</time>
													</div>
													${
														reply.is_own
															? `<a href="javascript:void(0)" x-type="reply" class="comment-menu" x-under="${item.comment_id}" x-value="${reply.comment_id}"><i class="fas fa-ellipsis-v"></i></a>`
															: ""
													}
												</div>
												<div class="comment-section-body">
													<p>
														${reply.comment_text}
													</p>
												</div>
											</section>
										`
											);
										}
									});
								});
								_.register_reply_event();
								_.register_comment_event();
								$("time.timeago").timeago();
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

				_UI.up_vote[i]?.addEventListener("click", async () => {
					let res = await this.vote(
						_UI.up_vote[i].getAttribute("x-value"),
						"up"
					);
					if (res.length) {
						_UI.up_vote[i].children[1].textContent = res[0].post_up_vote;
						_UI.down_vote[i].children[1].textContent = res[0].post_down_vote;
					}
				});
				_UI.down_vote[i]?.addEventListener("click", async () => {
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
				new Splide(_UI.elms[i]).mount();
			}

			_UI.post_button?.addEventListener("click", () => {
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
					url: `${base_url}/comment/insert`,
					type: "POST",
					dataType: "text",
					data: {
						comment: _UI.comment_input.value.trim(),
						"post-id": comment_post_id,
						type: is_replying ? "reply" : "comment",
						comment_id: select_comment_id,
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
			_UI.report_user?.addEventListener(
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
					url: `${base_url}/post/${props.url}`,
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
				(e) => (_UI.getClass("delete-post-modal")[0].style.display = "flex")
			);

			_UI.delete_delete.addEventListener("click", (e) => {
				$.ajax({
					url: `${base_url}/post/delete`,
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
					url: `${base_url}/post/getone`,
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
								<img src="${base_url}/uploads/${post_image_path}" />
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
					url: `${base_url}/post/update`,
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

			_UI.getId("create-group-trigger")?.addEventListener("click", () => {
				_UI.getClass("create-group-modal")[0].style.display = "flex";
			});

			_UI.getId("create-group-close").addEventListener("click", () => {
				_UI.getClass("create-group-modal")[0].style.display = "none";
			});

			_UI
				.getId("group-name")
				.addEventListener("keyup", () => this.search_group());

			for (let i = 0; i < _UI.getClass("search-interest").length; i++) {
				_UI
					.getClass("search-interest")
					[i].addEventListener("change", function () {
						if (search_categories.indexOf(this.getAttribute("x-value")) > -1) {
							search_categories = search_categories.filter((item) => {
								return item === this.getAttribute("x-value") ? false : true;
							});
						} else search_categories.push(this.getAttribute("x-value"));
						console.log(search_categories);
						controller.search_group();
					});
			}

			_UI.getId("search-group-trigger")?.addEventListener("click", function () {
				_UI.getClass("search-group-modal")[0].style.display = "flex";
			});

			_UI.getId("search-group-close")?.addEventListener("click", function () {
				_UI.getClass("search-group-modal")[0].style.display = "none";
			});

			_UI
				.getId("members-modal-trigger")
				?.addEventListener("click", function () {
					_UI.getClass("members-group-modal")[0].style.display = "flex";
					group_id = this.getAttribute("x-value");
				});

			_UI
				.getId("members-org-modal-trigger")
				?.addEventListener("click", function () {
					_UI.getClass("members-org-modal")[0].style.display = "flex";
					org_id = this.getAttribute("x-value");
				});

			_UI.getId("members-group-close").addEventListener("click", () => {
				_UI.getClass("members-group-modal")[0].style.display = "none";
			});

			_UI.getId("members-org-close").addEventListener("click", () => {
				_UI.getClass("members-org-modal")[0].style.display = "none";
			});

			for (let i = 0; i < _UI.getClass("group-members-remove").length; i++) {
				_UI
					.getClass("group-members-remove")
					[i].addEventListener("click", function () {
						delete_member_id = this.getAttribute("x-value");
						_UI.getClass("delete-member-modal")[0].style.display = "flex";
					});
			}

			for (let i = 0; i < _UI.getClass("org-members-remove").length; i++) {
				_UI
					.getClass("org-members-remove")
					[i].addEventListener("click", function () {
						delete_member_id = this.getAttribute("x-value");
						_UI.getClass("delete-org-member-modal")[0].style.display = "flex";
					});
			}

			_UI
				.getId("delete-member-cancel")
				.addEventListener(
					"click",
					() => (_UI.getClass("delete-member-modal")[0].style.display = "none")
				);

			_UI
				.getId("delete-org-member-cancel")
				.addEventListener(
					"click",
					() =>
						(_UI.getClass("delete-org-member-modal")[0].style.display = "none")
				);

			_UI.getId("delete-member-delete").addEventListener("click", (e) => {
				$.ajax({
					url: `${base_url}/member/delete`,
					type: "POST",
					dataType: "text",
					data: {
						user_detail_id: delete_member_id,
						group_id,
					},
					success: function (data) {
						if (data) location.reload();
					},
					error: function (data) {
						console.log(data);
					},
				});
			});

			_UI.getId("delete-org-member-delete").addEventListener("click", (e) => {
				$.ajax({
					url: `${base_url}/org_member/delete`,
					type: "POST",
					dataType: "text",
					data: {
						user_detail_id: delete_member_id,
						org_id,
					},
					success: function (data) {
						if (data) location.reload();
					},
					error: function (data) {
						console.log(data);
					},
				});
			});
		},
		group_user_update_status(status, ref, isBulk) {
			$.ajax({
				url: `${base_url}/group/update_status`,
				type: "POST",
				dataType: "text",
				data: {
					user_detail_id: !isBulk
						? ref.getAttribute("x-value")
						: bulk_group_user_update.map((item) => item.id),
					status,
					isBulk,
				},
				success: (data) => {
					console.log(data);
					if (isBulk) {
						if (data) {
							bulk_group_user_update.map((item) => {
								_UI.getId(item.ref.getAttribute("data-target")).remove();
							});
							bulk_group_user_update = [];
						}
					} else {
						if (data) {
							_UI.getId(ref.getAttribute("data-target")).remove();
							bulk_group_user_update = [];
						}
					}
					_UI.getId("select-all").checked = false;
				},
				error: function (data) {
					console.log(data);
				},
			});
		},
		org_user_update_status(status, ref, isBulk) {
			$.ajax({
				url: `${base_url}/org/update_status`,
				type: "POST",
				dataType: "text",
				data: {
					user_detail_id: !isBulk
						? ref.getAttribute("x-value")
						: bulk_group_user_update.map((item) => item.id),
					status,
					isBulk,
				},
				success: (data) => {
					console.log(data);
					if (isBulk) {
						if (data) {
							bulk_group_user_update.map((item) => {
								_UI.getId(item.ref.getAttribute("data-target")).remove();
							});
							bulk_group_user_update = [];
						}
					} else {
						if (data) {
							_UI.getId(ref.getAttribute("data-target")).remove();
							bulk_group_user_update = [];
						}
					}
					_UI.getId("select-all").checked = false;
				},
				error: function (data) {
					console.log(data);
				},
			});
		},
		update_post_reported(status, ref, isBulk) {
			$.ajax({
				url: `${base_url}/report/update_status`,
				type: "POST",
				dataType: "text",
				data: {
					post_id: !isBulk
						? ref.getAttribute("x-value")
						: bulk_post_reported.map((item) => item.id),
					status,
					isBulk,
				},
				success: (data) => {
					if (isBulk) {
						if (data) {
							bulk_post_reported.map((item) => {
								_UI.getId(item.ref.getAttribute("data-target")).remove();
							});
							bulk_post_reported = [];
						}
					} else {
						if (data) {
							_UI.getId(ref.getAttribute("data-target")).remove();
							bulk_post_reported = [];
						}
					}
					_UI.getId("select-reported-all").checked = false;
				},
				error: function (data) {
					console.log(data);
				},
			});
		},
		member_add_role(role_id) {
			let addrole = _UI.getClass("member-add-role");
			for (let i = 0; i < addrole.length; i++) {
				addrole[i].addEventListener("click", function () {
					$.ajax({
						url: `${base_url}/role/update_member_role`,
						type: "POST",
						dataType: "json",
						data: {
							role_id,
							user_detail_id: this.getAttribute("x-value"),
						},
						success: (data) => {
							if (data) {
								_UI.getId(`rm-${this.getAttribute("x-value")}`).remove();
								_UI.getClass("members-modal")[0].style.display = "none";
								_UI.getId(`rm-count-${role_id}`).textContent = data;
							}
						},
						error: (data) => console.log(data),
					});
				});
			}
		},
		member_org_add_role(role_id) {
			let addrole = _UI.getClass("member-org-add-role");
			for (let i = 0; i < addrole.length; i++) {
				addrole[i].addEventListener("click", function () {
					$.ajax({
						url: `${base_url}/role/update_org_member_role`,
						type: "POST",
						dataType: "json",
						data: {
							role_id,
							user_detail_id: this.getAttribute("x-value"),
						},
						success: (data) => {
							if (data) {
								_UI.getId(`rm-${this.getAttribute("x-value")}`).remove();
								_UI.getClass("members-modal")[0].style.display = "none";
								_UI.getId(`rm-count-${role_id}`).textContent = data;
							}
						},
						error: (data) => console.log(data),
					});
				});
			}
		},
		member_remove_role(role_id, og_id) {
			let removerole = _UI.getClass("member-remove-role");
			for (let i = 0; i < removerole.length; i++) {
				removerole[i].addEventListener("click", function () {
					$.ajax({
						url: `${base_url}/role/update_member_role`,
						type: "POST",
						dataType: "json",
						data: {
							role_id,
							user_detail_id: this.getAttribute("x-value"),
						},
						success: (data) => {
							console.log(data);
							if (data) {
								_UI.getId(`rmr-${this.getAttribute("x-value")}`).remove();
								_UI.getClass("members-modal")[0].style.display = "none";
								_UI.getId(`rm-count-${og_id}`).textContent = data - 1;
							}
						},
						error: (data) => console.log(data),
					});
				});
			}
		},
		member_org_remove_role(role_id, og_id) {
			let removerole = _UI.getClass("member-org-remove-role");
			for (let i = 0; i < removerole.length; i++) {
				removerole[i].addEventListener("click", function () {
					$.ajax({
						url: `${base_url}/role/update_org_member_role`,
						type: "POST",
						dataType: "json",
						data: {
							role_id,
							user_detail_id: this.getAttribute("x-value"),
						},
						success: (data) => {
							console.log(data);
							if (data) {
								_UI.getId(`rmr-${this.getAttribute("x-value")}`).remove();
								_UI.getClass("members-modal")[0].style.display = "none";
								_UI.getId(`rm-count-${og_id}`).textContent = data - 1;
							}
						},
						error: (data) => console.log(data),
					});
				});
			}
		},
		toggle_permission(value, id) {
			if (parseInt(value)) {
				_UI.getId(id).classList.remove("toggler-off");
				_UI.getId(id).children[0].classList.add("thumb-on");
			} else {
				_UI.getId(id).classList.add("toggler-off");
				_UI.getId(id).children[0].classList.remove("thumb-on");
			}
		},
		get_whole_name(val) {
			if (val == "mpc") return "member_request";
			if (val == "mrc") return "reported_content";
			if (val == "manr") return "manage_roles";
			if (val == "manp") return "manage_permission";
		},
		toggle_role_permission(id) {
			let _ = this;
			_UI.getId(id)?.addEventListener("click", function () {
				$.ajax({
					url: `${base_url}/role/toggle_permission`,
					type: "POST",
					dataType: "text",
					data: {
						role_id: current_role_id,
						permission: _.get_whole_name(id),
						value: this.classList.contains("toggler-off") ? 0 : 1,
					},
					success: (data) => console.log(data),
				});
			});
		},
		admin() {
			let elm = _UI.getClass("admin-trigger");
			let adm = _UI.getClass("admin-container");
			let _ = this;
			for (let i = 0; i < elm.length; i++) {
				elm[i].addEventListener("click", function () {
					for (let n = 0; n < adm.length; n++) {
						adm[n].classList.add("hidden");
						elm[n].classList.remove("admin-panel-selected");
					}
					this.classList.add("admin-panel-selected");
					_UI
						.getId(this.getAttribute("data-target"))
						?.classList.remove("hidden");
				});
			}

			_UI.getId("delete-cancel").addEventListener("click", () => {
				_UI.getClass("delete-modal")[0].style.display = "none";
			});

			let tog = _UI.getClass("toggler");
			for (let i = 0; i < tog.length; i++) {
				tog[i].addEventListener("click", function () {
					this.classList.toggle("toggler-off");
					this.children[0].classList.toggle("thumb-on");
				});
			}

			let mreq_app = _UI.getClass("member-request-approve");
			for (let i = 0; i < mreq_app.length; i++) {
				mreq_app[i].addEventListener("click", function (e) {
					_.group_user_update_status(1, this, false);
				});

				_UI
					.getClass("member-request-decline")
					[i].addEventListener("click", function (e) {
						_.group_user_update_status(2, this, false);
					});

				_UI
					.getClass("check-member-request")
					[i].addEventListener("click", function () {
						bulk_group_user_update = bulk_group_user_update.filter((item) => {
							return item.id !== this.getAttribute("x-value");
						});
						if (this.checked)
							bulk_group_user_update.push({
								id: this.getAttribute("x-value"),
								ref: this,
							});
					});
			}
			let mreq_org_app = _UI.getClass("member-org-request-approve");

			for (let i = 0; i < mreq_org_app.length; i++) {
				mreq_org_app[i].addEventListener("click", function (e) {
					_.org_user_update_status(1, this, false);
				});

				_UI
					.getClass("member-org-request-decline")
					[i].addEventListener("click", function (e) {
						_.org_user_update_status(2, this, false);
					});

				_UI
					.getClass("check-member-request")
					[i].addEventListener("click", function () {
						bulk_group_user_update = bulk_group_user_update.filter((item) => {
							return item.id !== this.getAttribute("x-value");
						});
						if (this.checked)
							bulk_group_user_update.push({
								id: this.getAttribute("x-value"),
								ref: this,
							});
					});
			}

			_UI.getId("select-all")?.addEventListener("click", function () {
				let input_select = _UI.getClass("check-member-request");
				bulk_group_user_update = [];
				for (let i = 0; i < input_select.length; i++) {
					input_select[i].checked = this.checked;
					if (this.checked)
						bulk_group_user_update.push({
							id: input_select[i].getAttribute("x-value"),
							ref: input_select[i],
						});
				}
			});

			_UI.getId("select-reported-all")?.addEventListener("click", function () {
				let input_select = _UI.getClass("select-reported-check");
				bulk_post_reported = [];
				for (let i = 0; i < input_select.length; i++) {
					input_select[i].checked = this.checked;
					if (this.checked)
						bulk_post_reported.push({
							id: input_select[i].getAttribute("x-value"),
							ref: input_select[i],
						});
				}
			});

			_UI.getId("member-request-approve-all")?.addEventListener("click", () => {
				this.group_user_update_status(1, null, true);
			});

			_UI.getId("member-request-decline-all")?.addEventListener("click", () => {
				this.group_user_update_status(2, null, true);
			});

			_UI.getId("reported-content-keep-all")?.addEventListener("click", () => {
				this.update_post_reported(1, null, true);
			});

			_UI
				.getId("reported-content-remove-all")
				?.addEventListener("click", () => {
					this.update_post_reported(2, null, true);
				});

			let reported = _UI.getClass("reported-content-keep");
			for (let i = 0; i < reported.length; i++) {
				reported[i].addEventListener("click", function () {
					_.update_post_reported(0, this, false);
				});
				_UI
					.getClass("reported-content-remove")
					[i].addEventListener("click", function () {
						_.update_post_reported(2, this, false);
					});

				_UI
					.getClass("select-reported-check")
					[i].addEventListener("click", function () {
						bulk_post_reported = bulk_post_reported.filter((item) => {
							return item.id !== this.getAttribute("x-value");
						});
						if (this.checked)
							bulk_post_reported.push({
								id: this.getAttribute("x-value"),
								ref: this,
							});
					});
			}

			_UI.getId("add-role-trigger")?.addEventListener("click", () => {
				$.ajax({
					url: `${base_url}/group/add_role`,
					type: "POST",
					dataType: "json",
					data: {
						role_name: _UI.getId("role-name").value,
					},
					success: (data) => {
						if (data.length) {
							location.reload();
							_UI.getId("role-container").insertAdjacentHTML(
								"afterbegin",
								`
								<tr>
                                    <td>${data[0].role_name}</td>
                                    <td>
                                        <i class="fas fa-user"></i>
                                        <span>0</span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="role-add-member" x-value="${data[0].role_id}">Add Members</a>
                                        <a href="javascript:void(0)" class="role-delete-member" x-value="${data[0].role_id}">Delete</a>
                                    </td>
                                </tr>
							`
							);
							_UI.getId("role-name").value = "";
						}
					},
					error: (data) => console.log(data),
				});
			});

			_UI.getId("add-org-role-trigger")?.addEventListener("click", () => {
				$.ajax({
					url: `${base_url}/org/add_role`,
					type: "POST",
					dataType: "json",
					data: {
						role_name: _UI.getId("role-name").value,
					},
					success: (data) => {
						if (data.length) {
							_UI.getId("role-container").insertAdjacentHTML(
								"afterbegin",
								`
								<tr>
                                    <td>${data[0].role_name}</td>
                                    <td>
                                        <i class="fas fa-user"></i>
                                        <span>0</span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="role-add-member" x-value="${data[0].role_id}">Add Members</a>
                                        <a href="javascript:void(0)" class="role-delete-member" x-value="${data[0].role_id}">Delete</a>
                                    </td>
                                </tr>
							`
							);
							_UI.getId("role-name").value = "";
						}
					},
					error: (data) => console.log(data),
				});
			});

			let delete_role = _UI.getClass("role-delete-member");

			for (let i = 0; i < delete_role.length; i++) {
				delete_role[i].addEventListener("click", function () {
					delete_role_id = this.getAttribute("x-value");
					_UI.getClass("delete-modal")[0].style.display = "flex";
				});
			}

			_UI.getId("delete-delete")?.addEventListener("click", () => {
				$.ajax({
					url: `${base_url}/role/delete_role`,
					type: "POST",
					dataType: "json",
					data: {
						role_id: delete_role_id,
					},
					success: (data) => {
						console.log(data);
						if (data) {
							_UI.getId(`role-c-${delete_role_id}`).remove();
							_UI.getClass("delete-modal")[0].style.display = "none";
						}
					},
				});
			});

			_UI
				.getId("members-modal-close")
				?.addEventListener(
					"click",
					() => (_UI.getClass("members-modal")[0].style.display = "none")
				);

			let mems = _UI.getClass("role-members");
			let org_mems = _UI.getClass("role-org-members");

			for (let i = 0; i < mems.length; i++) {
				mems[i]?.addEventListener("click", function () {
					_UI.getClass("members-modal-body")[0].textContent = null;
					$.ajax({
						url: `${base_url}/role/members`,
						type: "POST",
						dataType: "json",
						data: {
							role_id: this.getAttribute("x-value"),
						},
						success: (data) => {
							if (data) {
								_UI.getClass("members-modal")[0].style.display = "flex";
								data.map((item) => {
									let val = item.image_path.split(".");
									let path = val[0] == "user-1" ? "public/assets/" : "uploads/";
									_UI.getClass("members-modal-body")[0].insertAdjacentHTML(
										"afterbegin",
										`
									<div class="role-member-card" id="rmr-${item.user_detail_id}">
										<img src="${base_url}/${path}${item.image_path}" />
										<h1>${item.first_name} ${item.middle_name} ${item.last_name}</h1>
										<a href="javascript:void(0)" class="member-remove-role" x-value="${item.user_detail_id}">Remove</a>
									</div>
									`
									);
								});
								_.member_remove_role(-1, this.getAttribute("x-value"));
							}
						},
						error: (data) => console.log(data),
					});
				});

				_UI
					.getClass("role-add-member")
					[i]?.addEventListener("click", function () {
						_UI.getClass("members-modal-body")[0].textContent = null;
						$.ajax({
							url: `${base_url}/role/no_roles`,
							type: "POST",
							dataType: "json",
							success: (data) => {
								console.log(data);
								if (data) {
									_UI.getClass("members-modal")[0].style.display = "flex";
									data.map((item) => {
										let val = item.image_path.split(".");
										let path =
											val[0] == "user-1" ? "public/assets/" : "uploads/";
										_UI.getClass("members-modal-body")[0].insertAdjacentHTML(
											"afterbegin",
											`
										<div class="role-member-card" id="rm-${item.user_detail_id}">
											<img src="${base_url}/${path}${item.image_path}" />
											<h1>${item.first_name} ${item.middle_name} ${item.last_name}</h1>
											<a href="javascript:void(0)" class="member-add-role" x-value="${item.user_detail_id}">Add</a>
										</div>
											
										`
										);
									});
									_.member_add_role(this.getAttribute("x-value"));
								}
							},
							error: (data) => console.log(data),
						});
					});

				_UI
					.getClass("role-org-add-member")
					[i]?.addEventListener("click", function () {
						_UI.getClass("members-modal-body")[0].textContent = null;
						$.ajax({
							url: `${base_url}/role/org_no_roles`,
							type: "POST",
							dataType: "json",
							success: (data) => {
								console.log(data);
								if (data) {
									_UI.getClass("members-modal")[0].style.display = "flex";
									data.map((item) => {
										let val = item.image_path.split(".");
										let path =
											val[0] == "user-1" ? "public/assets/" : "uploads/";
										_UI.getClass("members-modal-body")[0].insertAdjacentHTML(
											"afterbegin",
											`
										<div class="role-member-card" id="rm-${item.user_detail_id}">
											<img src="${base_url}/${path}${item.image_path}" />
											<h1>${item.first_name} ${item.middle_name} ${item.last_name}</h1>
											<a href="javascript:void(0)" class="member-org-add-role" x-value="${item.user_detail_id}">Add</a>
										</div>
											
										`
										);
									});
									_.member_org_add_role(this.getAttribute("x-value"));
								}
							},
							error: (data) => console.log(data),
						});
					});
			}

			for (let i = 0; i < org_mems.length; i++) {
				org_mems[i]?.addEventListener("click", function () {
					_UI.getClass("members-modal-body")[0].textContent = null;
					$.ajax({
						url: `${base_url}/role/org_members`,
						type: "POST",
						dataType: "json",
						data: {
							role_id: this.getAttribute("x-value"),
						},
						success: (data) => {
							if (data) {
								_UI.getClass("members-modal")[0].style.display = "flex";
								data.map((item) => {
									let val = item.image_path.split(".");
									let path = val[0] == "user-1" ? "public/assets/" : "uploads/";
									_UI.getClass("members-modal-body")[0].insertAdjacentHTML(
										"afterbegin",
										`
									<div class="role-member-card" id="rmr-${item.user_detail_id}">
										<img src="${base_url}/${path}${item.image_path}" />
										<h1>${item.first_name} ${item.middle_name} ${item.last_name}</h1>
										<a href="javascript:void(0)" class="member-org-remove-role" x-value="${item.user_detail_id}">Remove</a>
									</div>

									`
									);
								});
								_.member_org_remove_role(0, this.getAttribute("x-value"));
							}
						},
						error: (data) => console.log(data),
					});
				});

				_UI
					.getClass("role-org-add-member")
					[i]?.addEventListener("click", function () {
						_UI.getClass("members-modal-body")[0].textContent = null;
						$.ajax({
							url: `${base_url}/role/org_no_roles`,
							type: "POST",
							dataType: "json",
							success: (data) => {
								console.log(data);
								if (data) {
									_UI.getClass("members-modal")[0].style.display = "flex";
									data.map((item) => {
										let val = item.image_path.split(".");
										let path =
											val[0] == "user-1" ? "public/assets/" : "uploads/";
										_UI.getClass("members-modal-body")[0].insertAdjacentHTML(
											"afterbegin",
											`
										<div class="role-member-card" id="rm-${item.user_detail_id}">
											<img src="${base_url}/${path}${item.image_path}" />
											<h1>${item.first_name} ${item.middle_name} ${item.last_name}</h1>
											<a href="javascript:void(0)" class="member-org-add-role" x-value="${item.user_detail_id}">Add</a>
										</div>
											
										`
										);
									});
									_.member_org_add_role(this.getAttribute("x-value"));
								}
							},
							error: (data) => console.log(data),
						});
					});
			}

			_UI.getId("role-permission")?.addEventListener("change", function () {
				current_role_id = this.value;
				$.ajax({
					url: `${base_url}/role/get_permission`,
					type: "POST",
					dataType: "json",
					data: {
						role_id: this.value,
					},
					success: (data) => {
						if (data) {
							let {
								member_request,
								reported_content,
								manage_roles,
								manage_permission,
							} = data[0];
							_.toggle_permission(member_request, "mpc");
							_.toggle_permission(reported_content, "mrc");
							_.toggle_permission(manage_roles, "manr");
							_.toggle_permission(manage_permission, "manp");
						}
					},
					error: (data) => console.log(data),
				});
			});

			this.toggle_role_permission("mpc");
			this.toggle_role_permission("mrc");
			this.toggle_role_permission("manr");
			this.toggle_role_permission("manp");

			current_role_id = _UI.getId("role-permission")?.value;

			_UI.getId("role-clear-permission")?.addEventListener("click", () => {
				$.ajax({
					url: `${base_url}/role/clear_permission`,
					type: "POST",
					dataType: "text",
					data: {
						role_id: current_role_id,
					},
					success: (data) => {
						if (data) {
							this.toggle_permission(0, "mpc");
							this.toggle_permission(0, "mrc");
							this.toggle_permission(0, "manr");
							this.toggle_permission(0, "manp");
						}
					},
				});
			});
		},
		account() {
			let original_pic = _UI.getId("account-image-source")?.src;
			_UI.getId("account-image")?.addEventListener("change", (e) => {
				if (e.target.files.length) {
					_UI.getId("account-image-source").src = URL.createObjectURL(
						e.target.files[0]
					);
				} else _UI.getId("account-image-source").src = original_pic;
			});
			_UI.getId("account-image-select")?.addEventListener("click", (e) => {
				_UI.getId("account-image").click();
			});
			_UI.getId("account-image-cancel")?.addEventListener("click", (e) => {
				_UI.getId("account-image-source").src = original_pic;
				_UI.getId("account-image").value = null;
			});

			for (let i = 0; i < _UI?.getClass("splide").length; i++) {
				new Splide(_UI.getClass("splide")[i]).mount();
			}
		},
		org_admin() {
			let val = _UI.getClass("org-validate");

			for (let i = 0; i < val.length; i++) {
				val[i].addEventListener("click", function () {
					$.ajax({
						url: `${base_url}/org_validate`,
						type: "POST",
						dataType: "text",
						data: {
							id: this.getAttribute("x-value"),
							type: this.getAttribute("x-type"),
						},
						success: (data) => {
							if (parseInt(data)) location.reload();
						},
						error: (data) => console.log(data),
					});
				});
			}
		},
	};
})(ui);
