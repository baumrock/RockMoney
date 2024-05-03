class _InputfieldRockMoney {
  getInputfield(el) {
    let input = el.closest("input");
    if (!input) return false;
    if (!input.closest(".InputfieldRockMoney")) return false;
    return input;
  }

  handleBlur(e) {
    let input = this.getInputfield(e.target);
    if (input) this.toFixed(e.target);
  }

  handleFocus(e) {
    if (!this.isMoneyField(e.target)) return;
    this.toFixed(e.target);
    this.getInputfield(e.target).select();
  }

  isMoneyField(el) {
    return !!this.getInputfield(el);
  }

  toFixed(el) {
    let val = el.value;
    if (!val) return;
    el.value = parseFloat(val).toFixed(2);
  }
}

var InputfieldRockMoney = new _InputfieldRockMoney();

document.addEventListener(
  "focusin",
  InputfieldRockMoney.handleFocus.bind(InputfieldRockMoney)
);
document.addEventListener(
  "focusout",
  InputfieldRockMoney.handleBlur.bind(InputfieldRockMoney)
);
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".InputfieldRockMoney input").forEach((input) => {
    InputfieldRockMoney.toFixed(input);
  });
});
