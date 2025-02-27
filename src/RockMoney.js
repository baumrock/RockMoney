class RockMoney {
  constructor(value) {
    this.locale = "de-AT";
    this.currencyStr = "EUR";
    this.currency = currency(value);

    // load settings from data-rockmoney attribute on <html> element
    // override locale + currencyStr
    let data =
      document.querySelector("html").getAttribute("data-rockmoney") || "";
    const params = new URLSearchParams(data.replace(/;/g, "&"));
    for (const [key, value] of params.entries()) {
      let [firstpart, secondpart] = key.split(":").map((part) => part.trim());
      if (firstpart === "currency") firstpart = "currencyStr";
      this[firstpart] = secondpart;
    }

    this.formatter = new Intl.NumberFormat(this.locale, {
      style: "currency",
      currency: this.currencyStr,
    });
  }

  by(val) {
    return new RockMoney(this.currency.divide(val));
  }

  float() {
    return this.currency.value;
  }

  format() {
    return this.toLocale();
  }

  minus(val) {
    return new RockMoney(this.currency.subtract(val));
  }

  plus(val) {
    return new RockMoney(this.currency.add(val));
  }

  times(val) {
    return new RockMoney(this.currency.multiply(val));
  }

  toLocale() {
    return this.formatter.format(this.currency.value);
  }
}
