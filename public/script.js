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
	};
})();

var controller = (function (_UI) {
	const tup_email_parser = /\w+([a-z])\.\w+([a-z])@tup.edu.ph/;
	let is_basic_good = false;
	let is_password_good = false;
	let boxes;

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
		posts_init() {
			for (let i = 0; i < _UI.post_option_toggle.length; i++) {
				_UI.post_option_toggle[i].addEventListener("click", function (e) {
					_UI.post_option.style.display =
						_UI.post_option.style.display === "block" ? "none" : "block";
					console.log(this);
					_UI.post_option.style.left = e.target.offsetLeft - 110 + "px";
					_UI.post_option.style.top = e.target.offsetTop - 10 + "px";
				});
				_UI.comment[i].addEventListener("click", (e) => {
					_UI.comment_modal.style.display = "block";
				});
				_UI.comment_modal_close.addEventListener("click", (e) => {
					_UI.comment_modal.style.display = "none";
				});
			}
			_UI.post_button.addEventListener("click", (e) => {
				_UI.post_modal.style.display = "flex";
			});

			_UI.post_modal_close.addEventListener("click", (e) => {
				_UI.post_modal.style.display = "none";
			});
		},
	};
})(ui);
