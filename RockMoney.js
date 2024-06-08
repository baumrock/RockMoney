class RockMoney {
  constructor(value) {
    this.currency = currency(value);

    let data =
      document.querySelector("html").getAttribute("data-rockmoney") || "";
    const params = new URLSearchParams(data.replace(/;/g, "&"));
    const locale = params.get("locale") || "de-AT";
    const curr = params.get("currency") || "EUR";
    this.formatter = new Intl.NumberFormat(locale, {
      style: "currency",
      currency: curr,
    });
  }

  by(val) {
    return new RockMoney(this.currency.value / val);
  }

  minus(val) {
    return new RockMoney(this.currency.value - val);
  }

  plus(val) {
    return new RockMoney(this.currency.value + val);
  }

  times(val) {
    return new RockMoney(this.currency.value * val);
  }

  toLocale() {
    return this.formatter.format(this.currency.value);
  }
}
