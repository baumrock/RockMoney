<div id='preview'></div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    let div = document.getElementById('preview');
    document.querySelectorAll('input[name="thousands"], input[name="decimal"], input[name="prefix"], input[name="suffix"], input[name="space"]').forEach(input => {
      input.addEventListener('change', updatePreview);
    });

    function updatePreview() {
      const thousands = document.querySelector('input[name="thousands"]').value || '';
      const decimal = document.querySelector('input[name="decimal"]').value || '';
      const prefix = document.querySelector('input[name="prefix"]').value || '';
      const suffix = document.querySelector('input[name="suffix"]').value || '';
      const space = document.querySelector('input[name="space"]').checked ? ' ' : '';

      const formatCurrency = (value) => {
        return prefix + space + currency(value, {
          separator: thousands,
          decimal: decimal,
          symbol: '',
        }).format() + space + suffix;
      };

      const values = [15, 150, 1500, 15000, 150000, 1500000, 15000000];
      const formattedValues = values.map(formatCurrency).join('<br>');

      div.innerHTML = formattedValues;
    }

    updatePreview(); // Initial call to set the preview on page load
  });
</script>