<style>
  pre {
    margin: 0;
    padding: 2px 5px;
    font-size: 12px;
  }

  .result {
    margin-top: 2px !important;
    font-size: 14px;
  }
</style>

<pre><code> // if you provide a string with three numbers after a dot or comma it will be parsed as thousands!
echo $money->parse("1.001")->format();</code></pre>
<p class=result><?= $money->parse("1.001")->format() ?></p>

<pre><code>// if you provide a PHP float it will be parsed as float and rounded to cents!
echo $money->parse(1.001)->format();</code></pre>
<p class=result><?= $money->parse(1.001)->format() ?></p>

<pre><code>// compare this example with the next one!
echo $money->parse(1.4)->minus(0.4)->format();</code></pre>
<p class=result><?= $money->parse(1.4)->minus(0.4)->format() ?></p>

<pre><code>// using floats instead of money objects will lead to wrong results!
var_dump(1.4 - 0.4)</code></pre>
<p class=result><?= var_dump(1.4 - 0.4) ?></p>

<pre><code>echo $money->parse(1.450)->format();</code></pre>
<p class=result><?= $money->parse(1.450)->format() ?></p>

<pre><code>echo $money->parse("1.450")->format();</code></pre>
<p class=result><?= $money->parse("1.450")->format() ?></p>

<pre><code>echo $money->parse(9.9)->times(1.2)->format();</code></pre>
<p class=result><?= $money->parse(9.9)->times(1.2)->format() ?></p>

<pre><code>echo $money->parse("€ 1,234")->format();</code></pre>
<p class=result><?= $money->parse("€ 1,234")->format() ?></p>

<pre><code>echo $money->parse("5,5")->times(3)->minus(2.5)->plus(0.2)->format();</code></pre>
<p class=result><?= $money->parse("5,5")->times(3)->minus(2.5)->plus(0.2)->format() ?></p>

<pre><code>// immutability
$net = $money->parse("1.499");
$vat = $net->times(0.2);
$gross = $net->plus($vat);
echo "net: $net";
echo "vat: $vat";
echo "gross: $gross";
</code></pre>
<p class=result>
  <?php
  $net = $money->parse("1.499");
  $vat = $net->times(0.2);
  $gross = $net->plus($vat);
  echo "net: $net<br>";
  echo "vat: $vat<br>";
  echo "gross: $gross<br>";
  ?>
</p>

<pre><code>// manual formatting
echo $money->parse("5,5")->format(decimal: '#', prefix: 'TEST: ', suffix: '!!');</code></pre>
<p class=result><?= $money->parse("5,5")->format(decimal: '#', prefix: 'TEST: ', suffix: '!!') ?></p>