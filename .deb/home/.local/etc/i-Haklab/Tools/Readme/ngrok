Documentation

Expose a local web server to the internet

ngrok allows you to expose a web server running on your local machine to the internet. Just tell ngrok what port your web server is listening on.

If you don't know what port your web server is listening on, it's probably port 80, the default for HTTP.
Example: Expose a web server on port 80 of your local machine to the internet

ngrok http 80

If your web server is serving secure content that isn't on port 443, you can provide the full address as well. Example: Expose a secure web server on port 5001 of your local machine to the internet

ngrok http https://localhost:5001

When you start ngrok, it will display a UI in your terminal with the public URL of your tunnel and other status and metrics information about connections made over your tunnel.

The ngrok console UI
ngrok by @inconshreveable

Tunnel Status                 online
Version                       2.0/2.0
Web Interface                 http://127.0.0.1:4040
Forwarding                    http://92832de0.ngrok.io -&gt; localhost:80
Forwarding                    https://92832de0.ngrok.io -&gt; localhost:80

Connnections                  ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00

Inspecting your traffic

ngrok provides a real-time web UI where you can introspect all of the HTTP traffic running over your tunnels. After you've started ngrok, just open http://localhost:4040">http://localhost:4040 in a web browser to inspect request details.
    
Try making a request to your public URL. After you have, look back at the inspection UI. You will see all of the details of the request and response including the time, duration, headers, query parameters and request payload as well as the raw bytes on the wire.

Detailed introspection of HTTP requests and responses

Replaying requests
Developing for webhooks issued by external APIs can often slow down your development cycle by requiring you do some work, like dialing a phone, to trigger the hook request. ngrok allows you to replay any request with a single click dramatically speeding up your iteration cycle. Click the <strong>Replay</strong> button at the top-right corner of any request on the web inspection UI to replay it. Replay any request against your tunneled web server with one click


Installing your Authtoken

Many advanced features of the ngrok.com service described in further sections require that you "https://dashboard.ngrok.com/signup" sign up for an account. Once you've signed up, you need to configure ngrok with the authtoken that appears on your dashboard. This will grant you access to account-only features. ngrok has a simple 'authtoken' command to make this easy. Under the hood, all the authtoken command does is to add (or modify) the auth property in your ngrok configuration file


Install your authtoken

ngrok authtoken YOUR_AUTHTOKEN


Getting a stable URL

On the free plan, ngrok's URLs are randomly generated and temporary. If you want to use the same URL every time, you need to upgrade to a paid plan so that you can use the subdomain option for a stable URL with HTTP or TLS tunnels and the remote-addr option for a stable address with TCP tunnels.


HTTP Tunnels
Custom subdomain names
ngrok assigns random hexadecimal names to the HTTP tunnels it opens for you.
This is okay for one-time personal uses. But if you're displaying the URL at a hackathon or integrating with a third-party webhook, it can be frustrating if the tunnel name changes or is difficult to read. You can specify a custom subdomain for your tunnel URL with the -subdomain switch.

Example: Open a tunnel with the subdomain 'inconshreveable':

ngrok http -subdomain=inconshreveable 80
ngrok by @inconshreveable
...
Forwarding                    http://inconshreveable.ngrok.io -&gt; 127.0.0.1:80
Forwarding                    https://inconshreveable.ngrok.io -&gt; 127.0.0.1:80


Password protecting your tunnel
Anyone who can guess your tunnel URL can access your local web server unless you protect it with a password. You can make your tunnels secure with the-auth switch. This enforces HTTP Basic Auth on all requests with the username and password you specify as an argument. Example: Password-protect your tunnel

ngrok http -auth="username:password" 8080



Tunnels on custom branded domains

Instead of your tunnel appearing as a subdomain of ngrok.io, you can run ngrok tunnels over your domains. To run a tunnel over dev.example.com, follow these steps:

Navigate to the Domains tab of your ngrok.com dashboard and click 'Add a domain'. Enter dev.example.com as a Reserved Domain. This guarantees that no one else can hijack your domain name with their own tunnel.
On your dashboard, click on the 'CNAME' icon to copy your CNAME target.
Create a DNS CNAME record from dev.example.com to your CNAME target. In this example, we would point the CNAME record to 2w9c34maz.cname.ngrok.io
Invoke ngrok with the -hostname switch and specify the name of your custom domain as an argument. Make sure the -region you specify matches the region in which you reserved your domain.
Example: Run a tunnel over a custom domain

ngrok http -region=us -hostname=dev.example.com 8000

Accessing custom domain tunnels over HTTPS will still work, but the certificate will not match. If you have a TLS certificate/key pair, try using a TLS tunnel.

Run a tunnel over a custom domain

ngrok http -region=us -hostname=dev.example.com 8000

Accessing custom domain tunnels over HTTPS will still work,but the certificate will not match. If you have a TLS certificate/key pair, try using a TLS tunnel.



Local HTTPS servers
ngrok assumes that the server it is forwarding to is listening for unencrypted HTTP traffic, but what if your server is listening for encrypted HTTPS traffic? You can specify a URL with an scheme to request that ngrok speak HTTPS to your local server.

Forward to an https server by specifying the https://
ngrok http https://localhost:8443

As a special case, ngrok assumes that if you forward to port 443 on any host that it should send HTTPS traffic and will act as if you specified an https:// URL.
Forward to the default https port on localhost
ngrok http 443
ngrok assumes that your local network is private and it <strong>does not do any validation of the TLS certificate presented by your local server



Rewriting the Host header
When forwarding to a local port, ngrok does not modify the tunneled HTTP requests at all, they are copied to your server byte-for-byte as they are received. Some application server like WAMP and MAMP and use the Host header for determining which development site to display. For this reason, ngrok can rewrite your requests with a modified Host header. Use the -host-header switch to rewrite incoming HTTP requests.
If rewrite is specified, the Host header will be rewritten to match the hostname portion of the forwarding address. Any other value will cause the Host header to be rewritten to that value.

Rewrite the Host header to 'site.dev'

<div class="well">
      <pre><code>ngrok http -host-header=rewrite site.dev:80</code></pre>
    </div>
    <h6 class="muted">Rewrite the Host header to 'example.com'</h6>
    <div class="well">
      <pre><code>ngrok http -host-header=example.com 80</code></pre>
    </div>
    <h3 id="http-file-urls">Serving local directories with ngrok's built-in fileserver</h3>
    <p>ngrok can serve local file system directories by using its own built-in fileserver, no separate
    server needed! You can serve files using the <code>file://</code> scheme when specifying the forwarding URL.
    </p>
    <p><strong>All paths must be specified as absolute paths</strong>,
    the <code>file://</code> URL scheme has no notion of relative paths.
    </p>
    <h6 class="muted">Share a folder on your computer with authentication</h6>
    <div class="well">
      <pre><code>ngrok http -auth="user:password" file:///Users/alan/share</code></pre>
    </div>
    <p>File URLs can look a little weird on Windows, but they work the same:</p>
    <h6 class="muted">Share a folder on your Windows computer</h6>
    <div class="well">
      <pre><code>ngrok http "file:///C:\Users\alan\Public Folder"</code></pre>
    </div>

    <h3 id="http-bind-tls">Tunneling only HTTP or HTTPS</h3>
    <p>By default, when ngrok runs an HTTP tunnel, it opens endpoints for both HTTP
  and HTTPS traffic. If you wish to only forward HTTP or HTTPS traffic, but not both,
  you can toggle this behavior with the <code>-bind-tls</code> switch.
    </p>
    <h6 class="muted">Example: Only listen on an HTTP tunnel endpoint</h6>
    <div class="well">
      <pre><code>ngrok http -bind-tls=false site.dev:80</code></pre>
    </div>
    <h6 class="muted">Example: Only listen on an HTTPS tunnel endpoint</h6>
    <div class="well">
      <pre><code>ngrok http -bind-tls=true site.dev:80</code></pre>
    </div>
    <h3 id="http-disable-inspection">Disabling Inspection</h3>
    <p>ngrok records each HTTP request and response over your tunnels for inspection
  and replay. While this is really useful for development, when you're running ngrok
  on production services, you may wish to disable it for security and performance.
  Use the <code>-inspect</code> switch to disable inspection on your tunnel.
    </p>
    <h6 class="muted">Example: An http tunnel with no inspection</h6>
    <div class="well">
      <pre><code>ngrok http -inspect=false 80</code></pre>
    </div>
    <h3 id="http-websockets">Websockets</h3>
    <p>
      Websocket endpoints work through ngrok's http tunnels without any changes.
      However, there is currently no support for introspecting them beyond the initial 101
      Switching Protocols response.
    </p>
    <h2 id="tls">TLS Tunnels</h2>
    <p>HTTPS tunnels terminate all TLS (SSL) traffic at the ngrok.com servers using ngrok.com
  certificates. For production-grade services, you'll want your tunneled traffic
  to be encrypted with your own TLS key and certificate. ngrok makes this extraordinarily easy
  with TLS tunnels.
    </p>
    <h6 class="muted">Forward TLS traffic to a local HTTPS server on port 443</h6>
    <div class="well">
      <pre><code>ngrok tls -subdomain=encrypted 443</code></pre>
    </div>
    <p>Once your tunnel is running, try accessing it with curl.
    </p>
    <div class="well">
      <pre><code>curl --insecure https://encrypted.ngrok.io</code></pre>
    </div>
    <h3 id="tls-cert-warnings">TLS Tunnels without certificate warnings</h3>
    <p>Notice that <code>--insecure</code> option in the previous <code>curl</code> command example? You need to specify that because
  your local HTTPS server doesn't have the TLS key and certificate necessary to terminate traffic for any <code>ngrok.io</code>
  subdomains. If you try to load up that page in a web browser, you'll notice that it tells you the page
  could be insecure because the certificate does not match.
    </p>
    <p>If you want your certificates to match and be protected from man-in-the-middle attacks, you need two things.
  First, you'll need to buy an SSL (TLS) certificate for a domain name that you own and configure your
  local web server to use that certificate and its private key to terminate TLS connections. How to do
  this is specific to your web server and SSL certificate provider and beyond the scope of this
  documentation. For the sake of example, we'll assume that you were issued an SSL certificate for the domain
  <code>secure.example.com</code>.
    </p>
    <p>Once you have your key and certificate and have installed them properly, it's now time to run a
  TLS tunnel on your own custom domain name. The instructions to set this up are identical to those
  described in the HTTP tunnels section: <a href="#http-custom-domains">Tunnels on custom domains</a>. The
  custom domain you register should be the same as the one in your SSL certificate (<code>secure.example.com</code>). After
  you've set up the custom domain, use the <code>-hostname</code> argument to start the TLS
  tunnel on your own domain.
    </p>
    <h6 class="muted">Forward TLS traffic over your own custom domain</h6>
    <div class="well">
      <pre><code>ngrok tls -region=us -hostname=secure.example.com 443</code></pre>
    </div>
    <h3 id="tls-termination">Terminating TLS connections</h3>
    <p>It's possible that the service you're trying to expose may not have the capability to terminate TLS connections.
  The ngrok client can do this for you so that you can encrypt your traffic end-to-end but not have to worry about
  whether the local service has TLS support. Specify both the <code>-crt</code> and <code>-key</code> command line
  options to specify the filesystem paths to your TLS certificate and key and the ngrok client will take care of
  terminating TLS connections for you.
    </p>
    <h6 class="muted">Offload TLS Termination to the ngrok client</h6>
    <div class="well">
      <pre><code>ngrok tls -region=us -hostname secure.example.com -key /path/to/tls.key -crt /path/to/tls.crt 80</code></pre>
    </div>
    <h3 id="tls-agnostic">Running non-HTTP services over TLS tunnels</h3>
    <p>ngrok TLS tunnels make <strong>no assumptions about the underlying protocol</strong> being transported. All
  examples in this documentation use HTTPS because it is the most common use case, but you can run
  run any TLS-wrapped protocol over a TLS tunnel (e.g. imaps, smtps, sips, etc) without any changes.
    </p>
    <h3 id="tls-compatibility">Compatible Clients</h3>
    <p>TLS tunnels work by inspecting the data present in the Server Name Information (SNI) extension on incoming TLS
  connections. Not all clients that initiate TLS connections support setting the SNI extension data. These clients
  will not work properly with ngrok's TLS tunnels. Fortunately, nearly all modern browsers use SNI. Some modern
  software libraries do not though. The following list of clients do not support SNI and will not work with TLS tunnels:
      <ul>
        <li>Microsoft Internet Explorer 6.0</li>
        <li>Microsoft Internet Explorer 7 &amp; 8 on Windows XP or earlier</li>
        <li>Native browser on Android 2.X</li>
        <li>Java <=1.6</li>
        <li><a href="https://stackoverflow.com/questions/18578439/using-requests-with-tls-doesnt-give-sni-support/18579484#18579484">Python 2.X, 3.0, 3.1 if required modules are not installed</a></li>
      </ul>A more complete list can be found on <a href="https://en.wikipedia.org/wiki/Server_Name_Indication#No_support">the Server Name Indiciation page on Wikipedia</a>
    </p>
    <h2 id="tcp">TCP Tunnels</h2>
    <p>Not all services you wish to expose are HTTP or TLS based. ngrok TCP tunnels allow you to expose
  any networked service that runs over TCP. This is commonly used to expose SSH, game servers, databases
  and more. Starting a TCP tunnel is easy.
    </p>
    <h6 class="muted">Expose a TCP based service running on port 1234</h6>
    <div class="well">
      <pre><code>ngrok tcp 1234</code></pre>
    </div>
    <h3 id="tcp-examples">Examples</h3>
    <h6>Expose an SSH server listening on the default port</h6>
    <div class="well">
      <pre><code>ngrok tcp 22</code></pre>
    </div>
    <h6>Expose a Postgres server listening on the default port</h6>
    <div class="well">
      <pre><code>ngrok tcp 5432</code></pre>
    </div>
    <h6>Expose an RDP server listening on the default port</h6>
    <div class="well">
      <pre><code>ngrok tcp 3389</code></pre>
    </div>
    <h3 id="tcp-remote-addr">Listening on a reserved remote address</h3>
    <p>Normally, the remote address and port is assigned randomly each time you start a TCP tunnel. For
  production services (and convenience) you often want a stable, guaranteed remote address. To do this,
  first, log in to your ngrok.com dashboard and click "Reserve Address" in the "Reserved TCP Addresses"
  section. Then use the <code>-remote-addr</code> option when invoking ngrok to bind a tunnel
  on your reserved TCP address. Make sure the <code>-region</code> you specify matches the region in which
  you reserved your address.
    </p>
    <h6>Bind a TCP tunnel on a reserved remote address</h6>
    <div class="well">
      <pre><code>ngrok tcp --region=us --remote-addr 1.tcp.ngrok.io:20301 22</code></pre>
    </div>
    <h2 id="more">More Tunneling Options</h2>
    <h3 id="wildcard">Wildcard domains</h3>
    <p>ngrok permits you to bind HTTP and TLS tunnels to wildcard domains. All wildcard domains,
  even those that are subdomains of <code>ngrok.io</code> must first be reserved for your account on your dashboard.
  When using <code>-hostname</code> or <code>-subdomain</code>, specify a leading asterisk
  to bind a wildcard domain.
    </p>
    <h6 class="muted">Bind a tunnel to receive traffic on all subdomains of <code>example.com</code></h6>
    <div class="well">
      <pre><code>ngrok http --region=us --hostname *.example.com 80</code></pre>
    </div>
    <h3 id="wildcard-rules">Wildcard domain rules</h3>
    <p>The use of wildcard domains creates ambiguities in some aspects of the ngrok.com service. The following
  rules are used to resolve these situations and are important to understand if you are using wildcard domains.
    </p>
    <p>For the purposes of example, assume you have reserved the address <code>*.example.com</code> for your account.
    </p>
    <ul>
      <li>Connections to nested subdomains (e.g. <code>foo.bar.baz.example.com</code>) will route to your wildcard tunnel.</li>
      <li>You may bind tunnels on any valid subdomain of <code>example.com</code> without creating an additional reserved domain entry.</li>
      <li>No other account may reserve <code>foo.example.com</code> or any other subdomain that would match a wildcard domain reserved by another account.</li>
      <li>Connections are routed to the most specific matching tunnel online. If you are running tunnels for both <code>foo.example.com</code> and <code>*.example.com</code>, requests to <code>foo.example.com</code> will always route to <code>foo.example.com</code></li>
    </ul>
    <h3 id="non-local">Forwarding to servers on a different machine (non-local services)</h3>
    <p>ngrok can forward to services that aren't running on your local machine. Instead of specifying
  a port number, just specify a network address and port instead.
    </p>
    <h6 class="muted">Example: Forward to a web server on a different machine</h6>
    <div class="well">
      <pre><code>ngrok http 192.168.1.1:8080</code></pre>
    </div>

    <h2 id="config">The ngrok configuration file</h2>
    <p>Sometimes your configuration for ngrok is too complex to be expressed in command line options. ngrok supports
  an optional, <strong>extremely simple YAML configuration file</strong> which provides you with the power to run multiple
  tunnels simultaneously as well as to tweak some of ngrok's more arcane settings.
    </p>
    <h3 id="config-location">Configuration file location</h3>
    <p>You may pass a path to an explicit configuration file with the <code>-config</code> option. This is recommended
  for all production deployments.
    </p>
    <h6 class="muted">Explicitly specify a configuration file location</h6>
    <div class="well">
      <pre><code>ngrok http -config=/opt/ngrok/conf/ngrok.yml 8000</code></pre>
    </div>
    <p>You may pass the <code>-config</code> option more than once. If you do, the first configuration is parsed and
  each successive configuration is merged on top of it. This allows you to have per-project ngrok configuration files
  with tunnel definitions but a master configuration file in your home directory with your authtoken and other
  global settings.
    </p>
    <h6 class="muted">Specify an additional configuration file with project-specific overrides</h6>
    <div class="well">
      <pre><code>ngrok start -config ~/ngrok.yml -config ~/projects/example/ngrok.yml demo admin</code></pre>
    </div>
    <h3 id="config-default-location">Default configuration file location</h3>
    <p>If you don't specify a location for a configuration file, ngrok tries to read
  one from the default location <code>$HOME/.ngrok2/ngrok.yml</code>. The configuration file
  is optional; no error is emitted if that path does not exist.
    </p>
    <p>In the default path, $HOME is the home directory for the current user as defined by your operating system.
  It is <strong>not the environment variable $HOME</strong>, although they are often the same. For
  major operating systems, if your username is <code>example</code> the default configuration would
  likely be found at the following paths:
    </p>
    <table class="table">
      <tr>
        <th>OS X</th>
        <td><code>/Users/example/.ngrok2/ngrok.yml</code>
        </td>
      </tr>
      <tr>
        <th>Linux</th>
        <td><code>/home/example/.ngrok2/ngrok.yml</code>
        </td>
      </tr>
      <tr>
        <th>Windows</th>
        <td><code>C:\Users\example\.ngrok2\ngrok.yml</code>
        </td>
      </tr>
    </table>
    <h3 id="tunnel-definitions">Tunnel definitions</h3>
    <p>The most common use of the configuration file is to define tunnel configurations. Defining
  tunnel configurations is useful because you may then start pre-configured tunnels by name
  from your command line without remembering all of the right arguments every time.
    </p>
    <p>Tunnels are defined as mapping of name -&gt; configuration under the <code>tunnels</code> property
  in your configuration file.
    </p>
    <h6 class="muted">Define two tunnels named 'httpbin' and 'demo'</h6>
    <div class="well">
      <pre><code>tunnels:
  httpbin:
    proto: http
    addr: 8000
    subdomain: alan-httpbin
  demo:
    proto: http
    addr: 9090
    hostname: demo.inconshreveable.com
    inspect: false
    auth: "demo:secret"</code></pre>
    </div>
    <h6 class="muted">Start the tunnel named 'httpbin'</h6>
    <div class="well">
      <pre><code>ngrok start httpbin</code></pre>
    </div>
    <p>Each tunnel you define is a map of configuration option names to values. The name of a configuration
  option is usually the same as its corresponding command line switch. Every tunnel must define
  <code>proto</code> and <code>addr</code>. Other properties are available and many are protocol-specific.
    </p>
    <h6>Tunnel Configuration Properties</h6>
    <table class="table">
      <tr>
        <th><code>proto</code>
        </th>
        <td style="width:100px">
          <div class="label label-warning">required</div>
          <div class="label label-info">all</div>
        </td>
        <td>tunnel protocol name, one of <code>http</code>, <code>tcp</code>, <code>tls</code></td>
      </tr>
      <tr>
        <th><code>addr</code>
        </th>
        <td>
          <div class="label label-warning">required</div>
          <div class="label label-info">all</div>
        </td>
        <td>forward traffic to this local port number or network address</td>
      </tr>
      <tr>
        <th><code>inspect</code>
        </th>
        <td>
          <div class="label label-info">http</div>
        </td>
        <td>enable http request inspection</td>
      </tr>
      <tr>
        <th><code>auth</code>
        </th>
        <td>
          <div class="label label-info">http</div>
        </td>
        <td>HTTP basic authentication credentials to enforce on tunneled requests</td>
      </tr>
      <tr>
        <th><code>host_header</code>
        </th>
        <td>
          <div class="label label-info">http</div>
        </td>
        <td>Rewrite the HTTP Host header to this value, or <code>preserve</code> to leave it unchanged</td>
      </tr>
      <tr>
        <th><code>bind_tls</code>
        </th>
        <td>
          <div class="label label-info">http</div>
        </td>
        <td>bind an HTTPS or HTTP endpoint or both <code>true</code>, <code>false</code>, or <code>both</both></td>
      </tr>
      <tr>
        <th><code>subdomain</code>
        </th>
        <td>
          <div class="label label-info">http</div>
          <div class="label label-info">tls</div>
        </td>
        <td>subdomain name to request. If unspecified, uses the tunnel name</td>
      </tr>
      <tr>
        <th><code>hostname</code>
        </th>
        <td>
          <div class="label label-info">http</div>
          <div class="label label-info">tls</div>
        </td>
        <td>hostname to request (requires reserved name and DNS CNAME)</td>
      </tr>
      <tr>
        <th><code>crt</code>
        </th>
        <td>
          <div class="label label-info">tls</div>
        </td>
        <td>PEM TLS certificate at this path to terminate TLS traffic before forwarding locally</td>
      </tr>
      <tr>
        <th><code>key</code>
        </th>
        <td>
          <div class="label label-info">tls</div>
        </td>
        <td>PEM TLS private key at this path to terminate TLS traffic before forwarding locally</td>
      </tr>
      <tr>
        <th><code>client_cas</code>
        </th>
        <td>
          <div class="label label-info">tls</div>
        </td>
        <td>PEM TLS certificate authority at this path will verify incoming TLS client connection certificates.</td>
      </tr>
      <tr>
        <th><code>remote_addr</code>
        </th>
        <td>
          <div class="label label-info">tcp</div>
        </td>
        <td>bind the remote TCP port on the given address</td>
      </tr>
      <tr id="tunnel-definitions-metadata">
        <th><code>metadata</code>
        </th>
        <td>
          <div class="label label-info">all</div>
        </td>
        <td>arbitrary user-defined metadata that will appear in the ngrok service API when listing tunnels</td>
      </tr>
    </table>
    <h3 id="multiple-tunnels">Running multiple simultaneous tunnels</h3>
    <p>You can pass multiple tunnel names to <code>ngrok start</code> and ngrok will run them all
  simultaneously.
    </p>
    <h6 class="muted">Start three named tunnels from the configuration file</h6>
    <div class="well">
      <pre><code>ngrok start admin ssh metrics</code></pre>
    </div>
    <div class="well">
      <pre><code>ngrok by @inconshreveable

Tunnel Status                 online
Version                       2.0/2.0
Web Interface                 http://127.0.0.1:4040
Forwarding                    http://admin.ngrok.io -&gt; 10.0.0.1:9001
Forwarding                    http://device-metrics.ngrok.io -&gt; localhost:2015
Forwarding                    https://admin.ngrok.io -&gt; 10.0.0.1:9001
Forwarding                    https://device-metrics.ngrok.io -&gt; localhost:2015
Forwarding                    tcp://0.tcp.ngrok.io:48590 -&gt; localhost:22
...</code></pre>
    </div>
    <p>You can also ask ngrok to start all of the tunnels defined in the configuration file with the
  <code>--all</code> switch.
    </p>
    <h6 class="muted">Start all tunnels defined in the configuration file</h6>
    <div class="well">
      <pre><code>ngrok start --all</code></pre>
    </div>
    <p>Conversely, you may ask ngrok to run without starting any tunnels with the <code>--none</code>
  switch. This is useful if you plan to manage ngrok's tunnels entirely via the API.
    </p>
    <h6 class="muted">Run ngrok without starting any tunnels</h6>
    <div class="well">
      <pre><code>ngrok start --none</code></pre>
    </div>
    <h3 id="config-examples">Example Configuration Files</h3>
    <p>Example configuration files are presented below. The subsequent section contains full documentation for all configuration parameters shown in these examples.</p>
    <h6 class="muted">Run tunnels for multiple virtual hosted development sites</h6>
    <div class="well">
      <pre><code>authtoken: 4nq9771bPxe8ctg7LKr_2ClH7Y15Zqe4bWLWF9p
tunnels:
  app-foo:
    addr: 80
    proto: http
    host_header: app-foo.dev
  app-bar:
    addr: 80
    proto: http
    host_header: app-bar.dev</code></pre>
    </div>
    <h6 class="muted">Tunnel a custom domain over both http and https with your own certificate</h6>
    <div class="well">
      <pre><code>authtoken: 4nq9771bPxe8ctg7LKr_2ClH7Y15Zqe4bWLWF9p
tunnels:
  myapp-http:
    addr: 80
    proto: http
    hostname: example.com
    bind_tls: false
  mypp-https:
    addr: 443
    proto: tls
    hostname: example.com</code></pre>
    </div>
    <h6 class="muted">Expose ngrok's web inspection interface and API over a tunnel</h6>
    <div class="well">
      <pre><code>authtoken: 4nq9771bPxe8ctg7LKr_2ClH7Y15Zqe4bWLWF9p
tunnels:
  myapp-http:
    addr: 4040
    proto: http
    subdomain: myapp-inspect
    auth: "user:secretpassword"
    inspect: false</code></pre>
    </div>
    <h6 class="muted">Example configuration file with all options</h6>
    <div class="well">
      <pre><code>authtoken: 4nq9771bPxe8ctg7LKr_2ClH7Y15Zqe4bWLWF9p
region: us
console_ui: true
http_proxy: false
inspect_db_size: 50000000
log_level: info
log_format: json
log: /var/log/ngrok.log
metadata: '{"serial": "00012xa-33rUtz9", "comment": "For customer alan@example.com"}'
root_cas: trusted
socks5_proxy: "socks5://localhost:9150"
update: false
update_channel: stable
web_addr: localhost:4040
tunnels:
  website:
    addr: 8888
    auth: bob:bobpassword
    bind_tls: true
    host_header: "myapp.dev"
    inspect: false
    proto: http
    subdomain: myapp

  e2etls:
    addr: 9000
    proto: tls
    hostname: myapp.example.com
    crt: example.crt
    key: example.key

  ssh-access:
    addr: 22
    proto: tcp
    remote_addr: 1.tcp.ngrok.io:12345</code></pre>
    </div>
    <h3 id="config-options">Configuration Options</h3>
    <h3 class="no-border" id="config_authtoken"><code>authtoken</code>
    </h3>
    <p>This option specifies the authentication token used to authenticate this client when it connects to the ngrok.com
  service. After you've created an ngrok.com account, your dashboard will display the authtoken assigned to your
  account.
    </p>
    <h6 class="muted">ngrok.yml specifying an authtoken</h6>
    <div class="well">
      <pre><code>authtoken: 4nq9771bPxe8ctg7LKr_2ClH7Y15Zqe4bWLWF9p</code></pre>
    </div>
    <h3 class="no-border" id="config_console_ui"><code>console_ui</code>
    </h3>
    <table class="table">
      <tr>
        <th><code>true</code>
        </th>
        <td></td>
        <td>enable the console UI</td>
      </tr>
      <tr>
        <th><code>false</code>
        </th>
        <td></td>
        <td>disable the console UI</td>
      </tr>
      <tr>
        <th><code>iftty</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>enable the UI only if standard out is a TTY (not a file or pipe)</td>
      </tr>
    </table>
    <h3 class="no-border" id="config_console_ui"><code>console_ui_color</code>
    </h3>
    <table class="table">
      <tr>
        <th><code>transparent</code>
        </th>
        <td></td>
        <td>don't set a background color when displaying the console UI</td>
      </tr>
      <tr>
        <th><code>black</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>set the console UI's background to black</td>
      </tr>
    </table>
    <h3 class="no-border" id="config_http_proxy"><code>http_proxy</code>
    </h3>
    <p>URL of an HTTP proxy to use for establishing the tunnel connection. Many HTTP proxies have connection
  size and duration limits that will cause ngrok to fail. Like many other networking tools, ngrok will also
  respect the environment variable <code>http_proxy</code> if it is set.
    </p>
    <h6 class="muted">Example of ngrok over an authenticated HTTP proxy</h6>
    <div class="well">
      <pre><code>http_proxy: "http://user:password@proxy.company:3128"</code></pre>
    </div>
    <h3 class="no-border" id="config_inspect_db_size"><code>inspect_db_size</code>
    </h3>
    <table class="table">
      <tr>
        <th>positive integers</th>
        <td></td>
        <td>size in bytes of the upper limit on memory to allocate to save requests over HTTP tunnels for inspection and replay.</td>
      </tr>
      <tr>
        <th><code>0</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>use the default allocation limit, 50MB</td>
      </tr>
      <tr>
        <th><code>-1</code>
        </th>
        <td></td>
        <td>disable the inspection database; this has the effective behavior of disabling inspection for all tunnels</td>
      </tr>
    </table>
    <h3 class="no-border" id="config_log_level"><code>log_level</code>
    </h3>
    <p>Logging level of detail. In increasing order of verbosity, possible values are:<code>crit</code>,<code>warn</code>,<code>error</code>,<code>info</code>,<code>debug</code>
    </p>
    <h3 class="no-border" id="config_log_format"><code>log_format</code>
    </h3>
    <p>Format of written log records.</p>
    <table class="table">
      <tr>
        <th><code>logfmt</code>
        </th>
        <td></td>
        <td>human and machine friendly key/value pairs</td>
      </tr>
      <tr>
        <th><code>json</code>
        </th>
        <td></td>
        <td>newline-separated JSON objects</td>
      </tr>
      <tr>
        <th><code>term</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>custom colored human format if standard out is a TTY, otherwise same as <code>logfmt</code></td>
      </tr>
    </table>
    <h3 class="no-border" id="config_log_target"><code>log</code>
    </h3>
    <p>Write logs to this target destination.</p>
    <table class="table">
      <tr>
        <th><code>stdout</code>
        </th>
        <td></td>
        <td>write to standard out</td>
      </tr>
      <tr>
        <th><code>stderr</code>
        </th>
        <td></td>
        <td>write to standard error</td>
      </tr>
      <tr>
        <th><code>false</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>disable logging</td>
      </tr>
      <tr>
        <th>other values</th>
        <td></td>
        <td>write log records to file path on disk</td>
      </tr>
    </table>
    <div class="well">
      <pre><code>log: /var/log/ngrok.log</code></pre>
    </div>
    <h3 class="no-border" id="config_metadata"><code>metadata</code>
    </h3>
    <p>Opaque, user-supplied string that will be returned as part of the ngrok.com API response to the <a href="/docs/ngrok-link#list-online-tunnels">List Online Tunnels resource</a> for all tunnels started by this client. This is a useful mechanism to identify tunnels by your own device or customer identifier. Maximum 4096 characters.</p>
    <div class="well">
      <pre><code>metadata: bad8c1c0-8fce-11e4-b4a9-0800200c9a66</code></pre>
    </div>
    <h3 class="no-border" id="config_region"><code>region</code>
    </h3>
    <p>Choose the region where the ngrok client will connect to host its tunnels.</p>
    <table class="table">
      <tr>
        <th><code>us</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>United States</td>
      </tr>
      <tr>
        <th><code>eu</code>
        </th>
        <td></td>
        <td>Europe</td>
      </tr>
      <tr>
        <th><code>ap</code>
        </th>
        <td></td>
        <td>Asia/Pacific</td>
      </tr>
      <tr>
        <th><code>au</code>
        </th>
        <td></td>
        <td>Australia</td>
      </tr>
      <tr>
        <th><code>sa</code>
        </th>
        <td></td>
        <td>South America</td>
      </tr>
      <tr>
        <th><code>jp</code>
        </th>
        <td></td>
        <td>Japan</td>
      </tr>
      <tr>
        <th><code>in</code>
        </th>
        <td></td>
        <td>India</td>
      </tr>
    </table>
    <h3 class="no-border" id="config_root_cas"><code>root_cas</code>
    </h3>
    <p>The root certificate authorities used to validate the TLS connection to the ngrok server.</p>
    <table class="table">
      <tr>
        <th><code>trusted</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>use only the trusted certificate root for the ngrok.com tunnel service</td>
      </tr>
      <tr>
        <th><code>host</code>
        </th>
        <td></td>
        <td>use the root certificates trusted by the host's operating system. You will likely want to use this option to connect to third-party ngrok servers.</td>
      </tr>
      <tr>
        <th>other values</th>
        <td></td>
        <td>path to a certificate PEM file on disk with certificate authorities to trust</td>
      </tr>
    </table>
    <h3 class="no-border" id="config_socks5_proxy"><code>socks5_proxy</code>
    </h3>
    <p>URL of a SOCKS5 proxy to use for establishing a connection to the ngrok server.</p>
    <div class="well">
      <pre><code>socks5_proxy: "socks5://localhost:9150"</code></pre>
    </div>
    <h3 class="no-border" id="config_tunnels"><code>tunnels</code>
    </h3>
    <p>A map of names to tunnel definitions. See <a href="#tunnel-definitions">Tunnel definitions</a> for more details.</p>
    <h3 class="no-border" id="config_update"><code>update</code>
    </h3>
    <table class="table">
      <tr>
        <th><code>true</code>
        </th>
        <td></td>
        <td>automatically update ngrok to the latest version, when available</td>
      </tr>
      <tr>
        <th><code>false</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>never update ngrok unless manually initiated by the user</td>
      </tr>
    </table>
    <h3 class="no-border" id="config_update_channel"><code>update_channel</code>
    </h3>
    <p>The update channel determines the stability of released builds to update to. Use 'stable' for all production deployments.</p>
    <table class="table">
      <tr>
        <th><code>stable</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>channel</td>
      </tr>
      <tr>
        <th><code>beta</code>
        </th>
        <td></td>
        <td>update to new beta builds when available</td>
      </tr>
    </table>
    <h3 class="no-border" id="config_web_addr"><code>web_addr</code>
    </h3>
    <p>Network address to bind on for serving the local web interface and api.</p>
    <table class="table">
      <tr>
        <th>network address</th>
        <td></td>
        <td>bind to this network address</td>
      </tr>
      <tr>
        <th><code>127.0.0.1:4040</code>
        </th>
        <td>
          <div class="label label-info">default</div>
        </td>
        <td>default network address</td>
      </tr>
      <tr>
        <th><code>false</code>
        </th>
        <td></td>
        <td>disable the web UI</td>
      </tr>
    </table>

    <h2 id="inspect">Web Inspection Interface</h2>
    <p>
      The ngrok client ships with a powerful realtime inspection interface which allows you to see what traffic is sent to your application server and what responses your server is returning.
    </p>
    <h3 id="inspect-requests">Inspecting requests</h3>
    <p>
    Every HTTP request through your tunnels will be displayed in the inspection interface. After you start ngrok, open <a href="http://localhost:4040">http://localhost:4040</a> in a browser.
    You will see all of the details of every request and response including the time, duration, source IP, headers, query parameters, request payload and response body as well as the raw bytes on the wire.
    </p>
    <p>
      The inspection interface has a few limitations. If an entity-body is too long, ngrok may only capture the initial portion of the request body. Furthermore, ngrok does not display provisional 100 responses from a server.
    </p>
    <div class="alert alert-info">
        Inspection is only supported for <code>http</code> tunnels. <code>tcp</code> and <code>tls</code> tunnels do not support any inspection.
    </div>
    <h6 class="muted">Detailed introspection of HTTP requests and responses</h6><img src="/static/img/inspect2.png" alt="" class="img-polaroid"/>
    <h3 id="inspect-body-validation">Request body validation</h3>
    <p>
      ngrok has special support for the most common data interchange formats in use on the web. Any XML or JSON data in request or response bodies is automatically pretty-printed for you and checked for syntax errors.
    </p>
    <h6 class="muted">The location of a JSON syntax error is highlighted</h6><img src="/static/img/syntax.png" alt="" class="img-polaroid"/>
    <h3 id="inspect-filtering">Filtering requests</h3>
    <p>
      Your application server may receive many requests, but you are often only interested in inspecting some of them. You can filter
      the requests that ngrok displays to you. You can filter based on the request path, response status code,
      size of the response body, duration of the request and the value of any header.
    </p>
    <h6 class="muted">Click the filter bar for filtering options</h6>
    <img src="/static/img/inspect-filter-select.png" alt="" class="img-polaroid"/>
    <p>
      <br />
      You may specify multiple filters. If you do, requests will only be shown if they much all filters.
    </p>
    <h6 class="muted">Filter requests by path and status code</h6>
    <img src="/static/img/inspect-filter.png" alt="" class="img-polaroid"/>
    <h3 id="inspect-replay">Replaying requests</h3>
    <p>
      Developing for webhooks issued by external APIs can often slow down your development cycle by requiring you do some work, like dialing a phone, to trigger the hook request. ngrok allows you to replay any request with a single click, dramatically speeding up your iteration cycle. Click the <strong>Replay</strong> button at the top-right corner of any request on the web inspection UI to replay it.
    </p>
    <h6 class="muted">Replay any request against your tunneled web server with one click</h6>
    <img src="/static/img/replay2.png" alt="" class="img-polaroid"/>
    <h3 id="inspect-replay-modified">Replaying modified requests</h3>
    <p>
      Sometimes you want to modify a request before you replay it to test a new behavior in your application server.
    </p>
    <h6 class="muted">Click the dropdown arrow on the 'Replay' button to modify a request before it is replayed</h6>
    <img src="/static/img/replay-modify-button.png" alt="" class="img-polaroid"/>
    <p>
      <br />
      The replay editor allows you to modify every aspect of the http request before replaying it, including the
      method, path, headers, trailers and request body.
    </p>
    <h6 class="muted">The request replay modification editor</h6>
    <img src="/static/img/replay-modify.png" alt="" class="img-polaroid"/>
    <h3 id="inspect-status">Status page: metrics and configuration</h3>
    <p>
      ngrok's local web interface has a dedicated status page that shows configuration and metrics
      information about the running ngrok process. You can access it at <a href="http://localhost:4040/status">http://localhost:4040/status</a>.
    </p>
    <p>
      The status page displays the configuration of each running tunnel and any global configuration options
      that ngrok has parsed from its configuration file.
    </p>
    <h6 class="muted">Tunnel and global configuration</h6>
    <img src="/static/img/status-configuration.png" alt="" class="img-polaroid"/>
    <p>
      <br />
      The status page also display metrics about the traffic through each tunnel. It display connection rates and connection duration
      percentiles for all tunnels. For http tunnels, it also displays http request rates and http response duration percentiles.
    </p>
    <h6 class="muted">Tunnel traffic metrics</h6>
    <img src="/static/img/status-metrics.png" alt="" class="img-polaroid"/>

    <h2 id="events">Event Subscriptions</h2>
    <p>Event Subscriptions capture events from your ngrok account and send them to configurable destinations like Amazon CloudWatch Logs, Amazon Kinesis (as a data stream) or Amazon Kinesis Firehose (as a delivery stream).</p>
    <p>You might create an Event Subscription to audit every time a team member gets created, updated, and deleted in your ngrok account, or every time somebody connects to an ngrok tunnel.</p>
    <h3 id="events-types">Event Types</h3>
    <p>Many objects within ngrok have corresponding events that are generated when an instance of the object is created, updated and deleted. For example, an event of type <code>ip_policy_created.v0</code> is generated when an IP Policy is created. All Event Types have a version, represented in the Event Type string following the period. The initial version for all Event Types is v0.</p> 
    <h3 id="events-sources-and-destinations">Parts of an Event Subscription</h3>
    <p>You can think of an Event Subscription as a set of <strong>Sources</strong> attached to one or more <strong>Destinations</strong>. Sources define which events to capture, and Destinations specify where to send those events.</p>
    <h4>Event Sources</h4>
    <p>An Event Source specifies the type of event to capture. A single Event Subscription can have many Sources.</p>
    <p>Some event types support filters and selectable fields. Not all selectable fields are usable in filters. A full list of event types and their fields follows. A field marked `filterable` indicates that it is usable in the filter for an event source.</p>
    
<h6>api_key_created.v0</h6>
<p>Triggers when an API key is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique API key resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI to the API resource of this API key</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of what uses the API key to authenticate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined data of this API key. optional, max 4096 bytes</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the api key was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>token</td>
		<td>string</td>
		<td></td>
		<td><p>the bearer token that can be placed into the Authorization header to authenticate request to the ngrok API. <strong>This value is only available one time, on the API response from key creation. Otherwise it is null.</strong></p>
</td>
	</tr>

</table>
<h6>api_key_deleted.v0</h6>
<p>Triggers when an API key is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique API key resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI to the API resource of this API key</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of what uses the API key to authenticate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined data of this API key. optional, max 4096 bytes</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the api key was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>token</td>
		<td>string</td>
		<td></td>
		<td><p>the bearer token that can be placed into the Authorization header to authenticate request to the ngrok API. <strong>This value is only available one time, on the API response from key creation. Otherwise it is null.</strong></p>
</td>
	</tr>

</table>
<h6>api_key_updated.v0</h6>
<p>Triggers when an API key is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique API key resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI to the API resource of this API key</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of what uses the API key to authenticate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined data of this API key. optional, max 4096 bytes</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the api key was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>token</td>
		<td>string</td>
		<td></td>
		<td><p>the bearer token that can be placed into the Authorization header to authenticate request to the ngrok API. <strong>This value is only available one time, on the API response from key creation. Otherwise it is null.</strong></p>
</td>
	</tr>

</table>
<h6>certificate_authority_created.v0</h6>
<p>Triggers when a certificate authority is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this Certificate Authority</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Certificate Authority API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the Certificate Authority was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this Certificate Authority. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this Certificate Authority. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>ca_pem</td>
		<td>string</td>
		<td></td>
		<td><p>raw PEM of the Certificate Authority</p>
</td>
	</tr><tr>
		<td>subject_common_name</td>
		<td>string</td>
		<td></td>
		<td><p>subject common name of the Certificate Authority</p>
</td>
	</tr><tr>
		<td>not_before</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this Certificate Authority becomes valid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>not_after</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this Certificate Authority becomes invalid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of actions the private key of this Certificate Authority can be used for</p>
</td>
	</tr><tr>
		<td>extended_key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>extended set of actions the private key of this Certificate Authority can be used for</p>
</td>
	</tr>

</table>
<h6>certificate_authority_deleted.v0</h6>
<p>Triggers when a certificate authority is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this Certificate Authority</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Certificate Authority API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the Certificate Authority was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this Certificate Authority. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this Certificate Authority. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>ca_pem</td>
		<td>string</td>
		<td></td>
		<td><p>raw PEM of the Certificate Authority</p>
</td>
	</tr><tr>
		<td>subject_common_name</td>
		<td>string</td>
		<td></td>
		<td><p>subject common name of the Certificate Authority</p>
</td>
	</tr><tr>
		<td>not_before</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this Certificate Authority becomes valid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>not_after</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this Certificate Authority becomes invalid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of actions the private key of this Certificate Authority can be used for</p>
</td>
	</tr><tr>
		<td>extended_key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>extended set of actions the private key of this Certificate Authority can be used for</p>
</td>
	</tr>

</table>
<h6>certificate_authority_updated.v0</h6>
<p>Triggers when a certificate authority is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this Certificate Authority</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Certificate Authority API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the Certificate Authority was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this Certificate Authority. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this Certificate Authority. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>ca_pem</td>
		<td>string</td>
		<td></td>
		<td><p>raw PEM of the Certificate Authority</p>
</td>
	</tr><tr>
		<td>subject_common_name</td>
		<td>string</td>
		<td></td>
		<td><p>subject common name of the Certificate Authority</p>
</td>
	</tr><tr>
		<td>not_before</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this Certificate Authority becomes valid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>not_after</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this Certificate Authority becomes invalid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of actions the private key of this Certificate Authority can be used for</p>
</td>
	</tr><tr>
		<td>extended_key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>extended set of actions the private key of this Certificate Authority can be used for</p>
</td>
	</tr>

</table>
<h6>domain_created.v0</h6>
<p>Triggers when a domain is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique reserved domain resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the reserved domain API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the reserved domain was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of what this reserved domain will be used for</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this reserved domain. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>domain</td>
		<td>string</td>
		<td></td>
		<td><p>hostname of the reserved domain</p>
</td>
	</tr><tr>
		<td>region</td>
		<td>string</td>
		<td></td>
		<td><p>reserve the domain in this geographic ngrok datacenter. Optional, default is us. (au, eu, ap, us, jp, in, sa)</p>
</td>
	</tr><tr>
		<td>cname_target</td>
		<td>string</td>
		<td></td>
		<td><p>DNS CNAME target for a custom hostname, or null if the reserved domain is a subdomain of *.ngrok.io</p>
</td>
	</tr><tr>
		<td>certificate.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>certificate.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr><tr>
		<td>certificate_management_policy.authority</td>
		<td>string</td>
		<td></td>
		<td><p>certificate authority to request certificates from. The only supported value is letsencrypt.</p>
</td>
	</tr><tr>
		<td>certificate_management_policy.private_key_type</td>
		<td>string</td>
		<td></td>
		<td><p>type of private key to use when requesting certificates. Defaults to rsa, can be either rsa or ecdsa.</p>
</td>
	</tr><tr>
		<td>certificate_management_status.renews_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the next renewal will be requested, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.error_code</td>
		<td>string</td>
		<td></td>
		<td><p>if present, an error code indicating why provisioning is failing. It may be either a temporary condition (INTERNAL_ERROR), or a permanent one the user must correct (DNS_ERROR).</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.msg</td>
		<td>string</td>
		<td></td>
		<td><p>a message describing the current status or error</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.started_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the provisioning job started, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.retries_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the provisioning job will be retried</p>
</td>
	</tr><tr>
		<td>acme_challenge_cname_target</td>
		<td>string</td>
		<td></td>
		<td><p>DNS CNAME target for the host _acme-challenge.example.com, where example.com is your reserved domain name. This is required to issue certificates for wildcard, non-ngrok reserved domains. Must be null for non-wildcard domains and ngrok subdomains.</p>
</td>
	</tr>

</table>
<h6>domain_deleted.v0</h6>
<p>Triggers when a domain is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique reserved domain resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the reserved domain API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the reserved domain was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of what this reserved domain will be used for</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this reserved domain. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>domain</td>
		<td>string</td>
		<td></td>
		<td><p>hostname of the reserved domain</p>
</td>
	</tr><tr>
		<td>region</td>
		<td>string</td>
		<td></td>
		<td><p>reserve the domain in this geographic ngrok datacenter. Optional, default is us. (au, eu, ap, us, jp, in, sa)</p>
</td>
	</tr><tr>
		<td>cname_target</td>
		<td>string</td>
		<td></td>
		<td><p>DNS CNAME target for a custom hostname, or null if the reserved domain is a subdomain of *.ngrok.io</p>
</td>
	</tr><tr>
		<td>certificate.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>certificate.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr><tr>
		<td>certificate_management_policy.authority</td>
		<td>string</td>
		<td></td>
		<td><p>certificate authority to request certificates from. The only supported value is letsencrypt.</p>
</td>
	</tr><tr>
		<td>certificate_management_policy.private_key_type</td>
		<td>string</td>
		<td></td>
		<td><p>type of private key to use when requesting certificates. Defaults to rsa, can be either rsa or ecdsa.</p>
</td>
	</tr><tr>
		<td>certificate_management_status.renews_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the next renewal will be requested, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.error_code</td>
		<td>string</td>
		<td></td>
		<td><p>if present, an error code indicating why provisioning is failing. It may be either a temporary condition (INTERNAL_ERROR), or a permanent one the user must correct (DNS_ERROR).</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.msg</td>
		<td>string</td>
		<td></td>
		<td><p>a message describing the current status or error</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.started_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the provisioning job started, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.retries_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the provisioning job will be retried</p>
</td>
	</tr><tr>
		<td>acme_challenge_cname_target</td>
		<td>string</td>
		<td></td>
		<td><p>DNS CNAME target for the host _acme-challenge.example.com, where example.com is your reserved domain name. This is required to issue certificates for wildcard, non-ngrok reserved domains. Must be null for non-wildcard domains and ngrok subdomains.</p>
</td>
	</tr>

</table>
<h6>domain_updated.v0</h6>
<p>Triggers when a domain is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique reserved domain resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the reserved domain API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the reserved domain was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of what this reserved domain will be used for</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this reserved domain. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>domain</td>
		<td>string</td>
		<td></td>
		<td><p>hostname of the reserved domain</p>
</td>
	</tr><tr>
		<td>region</td>
		<td>string</td>
		<td></td>
		<td><p>reserve the domain in this geographic ngrok datacenter. Optional, default is us. (au, eu, ap, us, jp, in, sa)</p>
</td>
	</tr><tr>
		<td>cname_target</td>
		<td>string</td>
		<td></td>
		<td><p>DNS CNAME target for a custom hostname, or null if the reserved domain is a subdomain of *.ngrok.io</p>
</td>
	</tr><tr>
		<td>certificate.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>certificate.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr><tr>
		<td>certificate_management_policy.authority</td>
		<td>string</td>
		<td></td>
		<td><p>certificate authority to request certificates from. The only supported value is letsencrypt.</p>
</td>
	</tr><tr>
		<td>certificate_management_policy.private_key_type</td>
		<td>string</td>
		<td></td>
		<td><p>type of private key to use when requesting certificates. Defaults to rsa, can be either rsa or ecdsa.</p>
</td>
	</tr><tr>
		<td>certificate_management_status.renews_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the next renewal will be requested, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.error_code</td>
		<td>string</td>
		<td></td>
		<td><p>if present, an error code indicating why provisioning is failing. It may be either a temporary condition (INTERNAL_ERROR), or a permanent one the user must correct (DNS_ERROR).</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.msg</td>
		<td>string</td>
		<td></td>
		<td><p>a message describing the current status or error</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.started_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the provisioning job started, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>certificate_management_status.provisioning_job.retries_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the provisioning job will be retried</p>
</td>
	</tr><tr>
		<td>acme_challenge_cname_target</td>
		<td>string</td>
		<td></td>
		<td><p>DNS CNAME target for the host _acme-challenge.example.com, where example.com is your reserved domain name. This is required to issue certificates for wildcard, non-ngrok reserved domains. Must be null for non-wildcard domains and ngrok subdomains.</p>
</td>
	</tr>

</table>
<h6>event_destination_created.v0</h6>
<p>Triggers when an Event Destination is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>Unique identifier for this Event Destination.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>Arbitrary user-defined machine-readable data of this Event Destination. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>Timestamp when the Event Destination was created, RFC 3339 format.</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>Human-readable description of the Event Destination. Optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>format</td>
		<td>string</td>
		<td></td>
		<td><p>The output format you would like to serialize events into when sending to their target. Currently the only accepted value is <code>JSON</code>.</p>
</td>
	</tr><tr>
		<td>target.firehose.auth.role.role_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An ARN that specifies the role that ngrok should use to deliver to the configured target.</p>
</td>
	</tr><tr>
		<td>target.firehose.auth.creds.aws_access_key_id</td>
		<td>string</td>
		<td></td>
		<td><p>The ID portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.firehose.auth.creds.aws_secret_access_key</td>
		<td>string</td>
		<td></td>
		<td><p>The secret portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.firehose.delivery_stream_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An Amazon Resource Name specifying the Firehose delivery stream to deposit events into.</p>
</td>
	</tr><tr>
		<td>target.kinesis.auth.role.role_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An ARN that specifies the role that ngrok should use to deliver to the configured target.</p>
</td>
	</tr><tr>
		<td>target.kinesis.auth.creds.aws_access_key_id</td>
		<td>string</td>
		<td></td>
		<td><p>The ID portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.kinesis.auth.creds.aws_secret_access_key</td>
		<td>string</td>
		<td></td>
		<td><p>The secret portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.kinesis.stream_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An Amazon Resource Name specifying the Kinesis stream to deposit events into.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.auth.role.role_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An ARN that specifies the role that ngrok should use to deliver to the configured target.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.auth.creds.aws_access_key_id</td>
		<td>string</td>
		<td></td>
		<td><p>The ID portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.auth.creds.aws_secret_access_key</td>
		<td>string</td>
		<td></td>
		<td><p>The secret portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.log_group_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An Amazon Resource Name specifying the CloudWatch Logs group to deposit events into.</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Event Destination API resource.</p>
</td>
	</tr>

</table>
<h6>event_destination_deleted.v0</h6>
<p>Triggers when an Event Destination is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>Unique identifier for this Event Destination.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>Arbitrary user-defined machine-readable data of this Event Destination. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>Timestamp when the Event Destination was created, RFC 3339 format.</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>Human-readable description of the Event Destination. Optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>format</td>
		<td>string</td>
		<td></td>
		<td><p>The output format you would like to serialize events into when sending to their target. Currently the only accepted value is <code>JSON</code>.</p>
</td>
	</tr><tr>
		<td>target.firehose.auth.role.role_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An ARN that specifies the role that ngrok should use to deliver to the configured target.</p>
</td>
	</tr><tr>
		<td>target.firehose.auth.creds.aws_access_key_id</td>
		<td>string</td>
		<td></td>
		<td><p>The ID portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.firehose.auth.creds.aws_secret_access_key</td>
		<td>string</td>
		<td></td>
		<td><p>The secret portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.firehose.delivery_stream_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An Amazon Resource Name specifying the Firehose delivery stream to deposit events into.</p>
</td>
	</tr><tr>
		<td>target.kinesis.auth.role.role_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An ARN that specifies the role that ngrok should use to deliver to the configured target.</p>
</td>
	</tr><tr>
		<td>target.kinesis.auth.creds.aws_access_key_id</td>
		<td>string</td>
		<td></td>
		<td><p>The ID portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.kinesis.auth.creds.aws_secret_access_key</td>
		<td>string</td>
		<td></td>
		<td><p>The secret portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.kinesis.stream_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An Amazon Resource Name specifying the Kinesis stream to deposit events into.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.auth.role.role_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An ARN that specifies the role that ngrok should use to deliver to the configured target.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.auth.creds.aws_access_key_id</td>
		<td>string</td>
		<td></td>
		<td><p>The ID portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.auth.creds.aws_secret_access_key</td>
		<td>string</td>
		<td></td>
		<td><p>The secret portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.log_group_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An Amazon Resource Name specifying the CloudWatch Logs group to deposit events into.</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Event Destination API resource.</p>
</td>
	</tr>

</table>
<h6>event_destination_updated.v0</h6>
<p>Triggers when an Event Destination is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>Unique identifier for this Event Destination.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>Arbitrary user-defined machine-readable data of this Event Destination. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>Timestamp when the Event Destination was created, RFC 3339 format.</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>Human-readable description of the Event Destination. Optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>format</td>
		<td>string</td>
		<td></td>
		<td><p>The output format you would like to serialize events into when sending to their target. Currently the only accepted value is <code>JSON</code>.</p>
</td>
	</tr><tr>
		<td>target.firehose.auth.role.role_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An ARN that specifies the role that ngrok should use to deliver to the configured target.</p>
</td>
	</tr><tr>
		<td>target.firehose.auth.creds.aws_access_key_id</td>
		<td>string</td>
		<td></td>
		<td><p>The ID portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.firehose.auth.creds.aws_secret_access_key</td>
		<td>string</td>
		<td></td>
		<td><p>The secret portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.firehose.delivery_stream_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An Amazon Resource Name specifying the Firehose delivery stream to deposit events into.</p>
</td>
	</tr><tr>
		<td>target.kinesis.auth.role.role_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An ARN that specifies the role that ngrok should use to deliver to the configured target.</p>
</td>
	</tr><tr>
		<td>target.kinesis.auth.creds.aws_access_key_id</td>
		<td>string</td>
		<td></td>
		<td><p>The ID portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.kinesis.auth.creds.aws_secret_access_key</td>
		<td>string</td>
		<td></td>
		<td><p>The secret portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.kinesis.stream_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An Amazon Resource Name specifying the Kinesis stream to deposit events into.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.auth.role.role_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An ARN that specifies the role that ngrok should use to deliver to the configured target.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.auth.creds.aws_access_key_id</td>
		<td>string</td>
		<td></td>
		<td><p>The ID portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.auth.creds.aws_secret_access_key</td>
		<td>string</td>
		<td></td>
		<td><p>The secret portion of an AWS access key.</p>
</td>
	</tr><tr>
		<td>target.cloudwatch_logs.log_group_arn</td>
		<td>string</td>
		<td></td>
		<td><p>An Amazon Resource Name specifying the CloudWatch Logs group to deposit events into.</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Event Destination API resource.</p>
</td>
	</tr>

</table>
<h6>event_subscription_created.v0</h6>
<p>Triggers when an Event Subscription is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>Unique identifier for this Event Subscription.</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Event Subscription API resource.</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>When the Event Subscription was created (RFC 3339 format).</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>Arbitrary customer supplied information intended to be machine readable. Optional, max 4096 chars.</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>Arbitrary customer supplied information intended to be human readable. Optional, max 255 chars.</p>
</td>
	</tr><tr>
		<td>sources.type</td>
		<td>string</td>
		<td></td>
		<td><p>Type of event for which an event subscription will trigger</p>
</td>
	</tr><tr>
		<td>sources.uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Event Source API resource.</p>
</td>
	</tr><tr>
		<td>destinations.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>destinations.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr>

</table>
<h6>event_subscription_deleted.v0</h6>
<p>Triggers when an Event Subascription is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>Unique identifier for this Event Subscription.</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Event Subscription API resource.</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>When the Event Subscription was created (RFC 3339 format).</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>Arbitrary customer supplied information intended to be machine readable. Optional, max 4096 chars.</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>Arbitrary customer supplied information intended to be human readable. Optional, max 255 chars.</p>
</td>
	</tr><tr>
		<td>sources.type</td>
		<td>string</td>
		<td></td>
		<td><p>Type of event for which an event subscription will trigger</p>
</td>
	</tr><tr>
		<td>sources.uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Event Source API resource.</p>
</td>
	</tr><tr>
		<td>destinations.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>destinations.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr>

</table>
<h6>event_subscription_updated.v0</h6>
<p>Triggers when an Event Subscription is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>Unique identifier for this Event Subscription.</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Event Subscription API resource.</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>When the Event Subscription was created (RFC 3339 format).</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>Arbitrary customer supplied information intended to be machine readable. Optional, max 4096 chars.</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>Arbitrary customer supplied information intended to be human readable. Optional, max 255 chars.</p>
</td>
	</tr><tr>
		<td>sources.type</td>
		<td>string</td>
		<td></td>
		<td><p>Type of event for which an event subscription will trigger</p>
</td>
	</tr><tr>
		<td>sources.uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the Event Source API resource.</p>
</td>
	</tr><tr>
		<td>destinations.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>destinations.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr>

</table>
<h6>http_request_complete.v0</h6>
<p>Triggers when an HTTP request completes.</p>
<p>
This event type supports filters and selectable fields.
</p>
<table class="table"><tr>
		<td>backend.connection_reused</td>
		<td>bool</td>
		<td></td>
		<td><p>True if ngrok reused a TCP connection to transmit the HTTP request to the upstream service.</p>
</td>
	</tr><tr>
		<td>basic_auth.decision</td>
		<td>string</td>
		<td></td>
		<td><p>&lsquo;allow&rsquo; if the Basic Auth module permitted the request to the upstream service, otherwise &lsquo;block&rsquo;</p>
</td>
	</tr><tr>
		<td>basic_auth.username</td>
		<td>string</td>
		<td></td>
		<td><p>The username in the HTTP basic auth credentials</p>
</td>
	</tr><tr>
		<td>circuit_breaker.decision</td>
		<td>string</td>
		<td></td>
		<td><p>Whether the HTTP request was sent to the upstream service. &lsquo;allow&rsquo; if the breaker was closed, &lsquo;block&rsquo; if the breaker was open, &lsquo;allow_while_open&rsquo; if the request was allowed while the breaker is open</p>
</td>
	</tr><tr>
		<td>compression.algorithm</td>
		<td>string</td>
		<td></td>
		<td><p>The compression algorithm used to encode responses from the endpoint. Either &lsquo;gzip&rsquo;, &lsquo;deflate&rsquo;, or &lsquo;none&rsquo;.</p>
</td>
	</tr><tr>
		<td>compression.bytes_saved</td>
		<td>int64</td>
		<td></td>
		<td><p>The difference between the size of the raw response and the size of the response as compressed by the Compression Module</p>
</td>
	</tr><tr>
		<td>conn.client_ip</td>
		<td>string</td>
		<td>filterable</td>
		<td><p>The source IP of the TCP connection to the ngrok edge</p>
</td>
	</tr><tr>
		<td>conn.server_ip</td>
		<td>string</td>
		<td>filterable</td>
		<td><p>The IP address of the server that received the request</p>
</td>
	</tr><tr>
		<td>conn.server_name</td>
		<td>string</td>
		<td>filterable</td>
		<td><p>The hostname associated with this connection.</p>
</td>
	</tr><tr>
		<td>conn.server_port</td>
		<td>int32</td>
		<td>filterable</td>
		<td><p>The port that the connection for this request came in on</p>
</td>
	</tr><tr>
		<td>conn.start_ts</td>
		<td>timestamp</td>
		<td></td>
		<td><p>The timestamp when the TCP connection to the ngrok edge is established</p>
</td>
	</tr><tr>
		<td>http.request.body_length</td>
		<td>int64</td>
		<td></td>
		<td><p>The size of the request body in bytes</p>
</td>
	</tr><tr>
		<td>http.request.headers</td>
		<td>Map&lt;string, List&lt;string&gt;&gt;</td>
		<td></td>
		<td><p>A map of normalized headers from the requesting client. Header keys are capitalized and header values are lowercased.</p>
</td>
	</tr><tr>
		<td>http.request.method</td>
		<td>string</td>
		<td></td>
		<td><p>The request method, normalized to lowercase</p>
</td>
	</tr><tr>
		<td>http.request.url.host</td>
		<td>string</td>
		<td></td>
		<td><p>The host component of the request URL</p>
</td>
	</tr><tr>
		<td>http.request.url.path</td>
		<td>string</td>
		<td></td>
		<td><p>The path component of the request URL</p>
</td>
	</tr><tr>
		<td>http.request.url.query</td>
		<td>string</td>
		<td></td>
		<td><p>The query string component of the request URL</p>
</td>
	</tr><tr>
		<td>http.request.url.raw</td>
		<td>string</td>
		<td></td>
		<td><p>The full URL of the request including scheme, host, path, and query string</p>
</td>
	</tr><tr>
		<td>http.request.url.scheme</td>
		<td>string</td>
		<td></td>
		<td><p>The scheme component of the request URL</p>
</td>
	</tr><tr>
		<td>http.request.user_agent</td>
		<td>string</td>
		<td></td>
		<td><p>The value of the User-Agent header in the request received by ngrok edge</p>
</td>
	</tr><tr>
		<td>http.response.body_length</td>
		<td>int64</td>
		<td></td>
		<td><p>The size of the response body in bytes</p>
</td>
	</tr><tr>
		<td>http.response.headers</td>
		<td>Map&lt;string, List&lt;string&gt;&gt;</td>
		<td></td>
		<td><p>A map of normalized response headers. Header keys are capitalized and header values are lowercased.</p>
</td>
	</tr><tr>
		<td>http.response.status_code</td>
		<td>int32</td>
		<td></td>
		<td><p>The status code of the response returned by the ngrok edge</p>
</td>
	</tr><tr>
		<td>ip_policy.decision</td>
		<td>string</td>
		<td></td>
		<td><p>&lsquo;allow&rsquo; if IP Policy module permitted the request to the upstream service, &lsquo;block&rsquo; otherwise</p>
</td>
	</tr><tr>
		<td>oauth.app_client_id</td>
		<td>string</td>
		<td></td>
		<td><p>The OAuth application client ID</p>
</td>
	</tr><tr>
		<td>oauth.decision</td>
		<td>string</td>
		<td></td>
		<td><p>&lsquo;allow&rsquo; if the OAuth module permitted the request to the upstream service, &lsquo;block&rsquo; otherwise</p>
</td>
	</tr><tr>
		<td>oauth.user.id</td>
		<td>string</td>
		<td></td>
		<td><p>The authenticated user&rsquo;s ID returned by the OAuth provider</p>
</td>
	</tr><tr>
		<td>oauth.user.name</td>
		<td>string</td>
		<td></td>
		<td><p>The authenticated user&rsquo;s name returned by the OAuth provider</p>
</td>
	</tr><tr>
		<td>tls.cipher_suite</td>
		<td>string</td>
		<td></td>
		<td><p>The cipher suite selected during the TLS handshake</p>
</td>
	</tr><tr>
		<td>tls.client_cert.serial_number</td>
		<td>string</td>
		<td></td>
		<td><p>The serial number of the client&rsquo;s leaf TLS certificate in the Mutual TLS handshake</p>
</td>
	</tr><tr>
		<td>tls.client_cert.subject.cn</td>
		<td>string</td>
		<td></td>
		<td><p>The subject common name of the client&rsquo;s leaf TLS certificate in the Mutual TLS handshake</p>
</td>
	</tr><tr>
		<td>tls.version</td>
		<td>string</td>
		<td></td>
		<td><p>The version of the TLS protocol used between the client and the ngrok edge</p>
</td>
	</tr><tr>
		<td>webhook_validation.decision</td>
		<td>string</td>
		<td></td>
		<td><p>&lsquo;allow&rsquo; if the Webhook Verification module permitted the request to the upstream service, &lsquo;block&rsquo; otherwise</p>
</td>
	</tr>
</table>
<h6>ip_policy_created.v0</h6>
<p>Triggers when an IP Policy is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this IP policy</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the IP Policy API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the IP policy was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of the source IPs of this IP policy. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this IP policy. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>action</td>
		<td>string</td>
		<td></td>
		<td><p>the IP policy action. Supported values are <code>allow</code> or <code>deny</code></p>
</td>
	</tr>

</table>
<h6>ip_policy_deleted.v0</h6>
<p>Triggers when an IP Policy is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this IP policy</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the IP Policy API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the IP policy was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of the source IPs of this IP policy. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this IP policy. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>action</td>
		<td>string</td>
		<td></td>
		<td><p>the IP policy action. Supported values are <code>allow</code> or <code>deny</code></p>
</td>
	</tr>

</table>
<h6>ip_policy_rule_created.v0</h6>
<p>Triggers when an IP Policy Rule is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this IP policy rule</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the IP policy rule API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the IP policy rule was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of the source IPs of this IP rule. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this IP policy rule. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>cidr</td>
		<td>string</td>
		<td></td>
		<td><p>an IP or IP range specified in CIDR notation. IPv4 and IPv6 are both supported.</p>
</td>
	</tr><tr>
		<td>ip_policy.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>ip_policy.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr>

</table>
<h6>ip_policy_rule_deleted.v0</h6>
<p>Triggers when an IP Policy Rule is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this IP policy rule</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the IP policy rule API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the IP policy rule was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of the source IPs of this IP rule. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this IP policy rule. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>cidr</td>
		<td>string</td>
		<td></td>
		<td><p>an IP or IP range specified in CIDR notation. IPv4 and IPv6 are both supported.</p>
</td>
	</tr><tr>
		<td>ip_policy.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>ip_policy.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr>

</table>
<h6>ip_policy_rule_updated.v0</h6>
<p>Triggers when an IP Policy Rule is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this IP policy rule</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the IP policy rule API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the IP policy rule was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of the source IPs of this IP rule. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this IP policy rule. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>cidr</td>
		<td>string</td>
		<td></td>
		<td><p>an IP or IP range specified in CIDR notation. IPv4 and IPv6 are both supported.</p>
</td>
	</tr><tr>
		<td>ip_policy.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>ip_policy.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr>

</table>
<h6>ip_policy_updated.v0</h6>
<p>Triggers when an IP Policy is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this IP policy</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the IP Policy API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the IP policy was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of the source IPs of this IP policy. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this IP policy. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>action</td>
		<td>string</td>
		<td></td>
		<td><p>the IP policy action. Supported values are <code>allow</code> or <code>deny</code></p>
</td>
	</tr>

</table>
<h6>ip_restriction_created.v0</h6>
<p>Triggers when an IP Restriction is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this IP restriction</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the IP restriction API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the IP restriction was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this IP restriction. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this IP restriction. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>enforced</td>
		<td>boolean</td>
		<td></td>
		<td><p>true if the IP restriction will be enforced. if false, only warnings will be issued</p>
</td>
	</tr><tr>
		<td>type</td>
		<td>string</td>
		<td></td>
		<td><p>the type of IP restriction. this defines what traffic will be restricted with the attached policies. four values are currently supported: <code>dashboard</code>, <code>api</code>, <code>agent</code>, and <code>endpoints</code></p>
</td>
	</tr><tr>
		<td>ip_policies.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>ip_policies.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr>

</table>
<h6>ip_restriction_deleted.v0</h6>
<p>Triggers when an IP Restriction is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this IP restriction</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the IP restriction API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the IP restriction was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this IP restriction. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this IP restriction. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>enforced</td>
		<td>boolean</td>
		<td></td>
		<td><p>true if the IP restriction will be enforced. if false, only warnings will be issued</p>
</td>
	</tr><tr>
		<td>type</td>
		<td>string</td>
		<td></td>
		<td><p>the type of IP restriction. this defines what traffic will be restricted with the attached policies. four values are currently supported: <code>dashboard</code>, <code>api</code>, <code>agent</code>, and <code>endpoints</code></p>
</td>
	</tr><tr>
		<td>ip_policies.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>ip_policies.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr>

</table>
<h6>ip_restriction_updated.v0</h6>
<p>Triggers when an IP Restriction is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this IP restriction</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the IP restriction API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the IP restriction was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this IP restriction. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this IP restriction. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>enforced</td>
		<td>boolean</td>
		<td></td>
		<td><p>true if the IP restriction will be enforced. if false, only warnings will be issued</p>
</td>
	</tr><tr>
		<td>type</td>
		<td>string</td>
		<td></td>
		<td><p>the type of IP restriction. this defines what traffic will be restricted with the attached policies. four values are currently supported: <code>dashboard</code>, <code>api</code>, <code>agent</code>, and <code>endpoints</code></p>
</td>
	</tr><tr>
		<td>ip_policies.id</td>
		<td>string</td>
		<td></td>
		<td><p>a resource identifier</p>
</td>
	</tr><tr>
		<td>ip_policies.uri</td>
		<td>string</td>
		<td></td>
		<td><p>a uri for locating a resource</p>
</td>
	</tr>

</table>
<h6>ssh_certificate_authority_created.v0</h6>
<p>Triggers when an SSH certificate authority is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this SSH Certificate Authority</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the SSH Certificate Authority API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the SSH Certificate Authority API resource was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this SSH Certificate Authority. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this SSH Certificate Authority. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>raw public key for this SSH Certificate Authority</p>
</td>
	</tr><tr>
		<td>key_type</td>
		<td>string</td>
		<td></td>
		<td><p>the type of private key for this SSH Certificate Authority</p>
</td>
	</tr>

</table>
<h6>ssh_certificate_authority_deleted.v0</h6>
<p>Triggers when an SSH certificate authority is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this SSH Certificate Authority</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the SSH Certificate Authority API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the SSH Certificate Authority API resource was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this SSH Certificate Authority. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this SSH Certificate Authority. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>raw public key for this SSH Certificate Authority</p>
</td>
	</tr><tr>
		<td>key_type</td>
		<td>string</td>
		<td></td>
		<td><p>the type of private key for this SSH Certificate Authority</p>
</td>
	</tr>

</table>
<h6>ssh_certificate_authority_updated.v0</h6>
<p>Triggers when an SSH certificate authority is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this SSH Certificate Authority</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the SSH Certificate Authority API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the SSH Certificate Authority API resource was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this SSH Certificate Authority. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this SSH Certificate Authority. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>raw public key for this SSH Certificate Authority</p>
</td>
	</tr><tr>
		<td>key_type</td>
		<td>string</td>
		<td></td>
		<td><p>the type of private key for this SSH Certificate Authority</p>
</td>
	</tr>

</table>
<h6>ssh_host_certificate_created.v0</h6>
<p>Triggers when an SSH host certificate is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this SSH Host Certificate</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the SSH Host Certificate API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the SSH Host Certificate API resource was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this SSH Host Certificate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this SSH Host Certificate. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>a public key in OpenSSH Authorized Keys format that this certificate signs</p>
</td>
	</tr><tr>
		<td>key_type</td>
		<td>string</td>
		<td></td>
		<td><p>the key type of the <code>public_key</code>, one of <code>rsa</code>, <code>ecdsa</code> or <code>ed25519</code></p>
</td>
	</tr><tr>
		<td>ssh_certificate_authority_id</td>
		<td>string</td>
		<td></td>
		<td><p>the ssh certificate authority that is used to sign this ssh host certificate</p>
</td>
	</tr><tr>
		<td>principals</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>the list of principals included in the ssh host certificate. This is the list of hostnames and/or IP addresses that are authorized to serve SSH traffic with this certificate. Dangerously, if no principals are specified, this certificate is considered valid for all hosts.</p>
</td>
	</tr><tr>
		<td>valid_after</td>
		<td>string</td>
		<td></td>
		<td><p>the time when the ssh host certificate becomes valid, in RFC 3339 format.</p>
</td>
	</tr><tr>
		<td>valid_until</td>
		<td>string</td>
		<td></td>
		<td><p>the time after which the ssh host certificate becomes invalid, in RFC 3339 format. the OpenSSH certificates RFC calls this <code>valid_before</code>.</p>
</td>
	</tr><tr>
		<td>certificate</td>
		<td>string</td>
		<td></td>
		<td><p>the signed SSH certificate in OpenSSH Authorized Keys format. this value should be placed in a <code>-cert.pub</code> certificate file on disk that should be referenced in your <code>sshd_config</code> configuration file with a <code>HostCertificate</code> directive</p>
</td>
	</tr>

</table>
<h6>ssh_host_certificate_deleted.v0</h6>
<p>Triggers when an SSH host certificate is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this SSH Host Certificate</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the SSH Host Certificate API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the SSH Host Certificate API resource was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this SSH Host Certificate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this SSH Host Certificate. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>a public key in OpenSSH Authorized Keys format that this certificate signs</p>
</td>
	</tr><tr>
		<td>key_type</td>
		<td>string</td>
		<td></td>
		<td><p>the key type of the <code>public_key</code>, one of <code>rsa</code>, <code>ecdsa</code> or <code>ed25519</code></p>
</td>
	</tr><tr>
		<td>ssh_certificate_authority_id</td>
		<td>string</td>
		<td></td>
		<td><p>the ssh certificate authority that is used to sign this ssh host certificate</p>
</td>
	</tr><tr>
		<td>principals</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>the list of principals included in the ssh host certificate. This is the list of hostnames and/or IP addresses that are authorized to serve SSH traffic with this certificate. Dangerously, if no principals are specified, this certificate is considered valid for all hosts.</p>
</td>
	</tr><tr>
		<td>valid_after</td>
		<td>string</td>
		<td></td>
		<td><p>the time when the ssh host certificate becomes valid, in RFC 3339 format.</p>
</td>
	</tr><tr>
		<td>valid_until</td>
		<td>string</td>
		<td></td>
		<td><p>the time after which the ssh host certificate becomes invalid, in RFC 3339 format. the OpenSSH certificates RFC calls this <code>valid_before</code>.</p>
</td>
	</tr><tr>
		<td>certificate</td>
		<td>string</td>
		<td></td>
		<td><p>the signed SSH certificate in OpenSSH Authorized Keys format. this value should be placed in a <code>-cert.pub</code> certificate file on disk that should be referenced in your <code>sshd_config</code> configuration file with a <code>HostCertificate</code> directive</p>
</td>
	</tr>

</table>
<h6>ssh_host_certificate_updated.v0</h6>
<p>Triggers when an SSH host certificate is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this SSH Host Certificate</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the SSH Host Certificate API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the SSH Host Certificate API resource was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this SSH Host Certificate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this SSH Host Certificate. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>a public key in OpenSSH Authorized Keys format that this certificate signs</p>
</td>
	</tr><tr>
		<td>key_type</td>
		<td>string</td>
		<td></td>
		<td><p>the key type of the <code>public_key</code>, one of <code>rsa</code>, <code>ecdsa</code> or <code>ed25519</code></p>
</td>
	</tr><tr>
		<td>ssh_certificate_authority_id</td>
		<td>string</td>
		<td></td>
		<td><p>the ssh certificate authority that is used to sign this ssh host certificate</p>
</td>
	</tr><tr>
		<td>principals</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>the list of principals included in the ssh host certificate. This is the list of hostnames and/or IP addresses that are authorized to serve SSH traffic with this certificate. Dangerously, if no principals are specified, this certificate is considered valid for all hosts.</p>
</td>
	</tr><tr>
		<td>valid_after</td>
		<td>string</td>
		<td></td>
		<td><p>the time when the ssh host certificate becomes valid, in RFC 3339 format.</p>
</td>
	</tr><tr>
		<td>valid_until</td>
		<td>string</td>
		<td></td>
		<td><p>the time after which the ssh host certificate becomes invalid, in RFC 3339 format. the OpenSSH certificates RFC calls this <code>valid_before</code>.</p>
</td>
	</tr><tr>
		<td>certificate</td>
		<td>string</td>
		<td></td>
		<td><p>the signed SSH certificate in OpenSSH Authorized Keys format. this value should be placed in a <code>-cert.pub</code> certificate file on disk that should be referenced in your <code>sshd_config</code> configuration file with a <code>HostCertificate</code> directive</p>
</td>
	</tr>

</table>
<h6>ssh_public_key_created.v0</h6>
<p>Triggers when an SSH public key is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique ssh credential resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the ssh credential API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the ssh credential was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of who or what will use the ssh credential to authenticate. Optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this ssh credential. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>the PEM-encoded public key of the SSH keypair that will be used to authenticate</p>
</td>
	</tr><tr>
		<td>acl</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>optional list of ACL rules. If unspecified, the credential will have no restrictions. The only allowed ACL rule at this time is the <code>bind</code> rule. The <code>bind</code> rule allows the caller to restrict what domains and addresses the token is allowed to bind. For example, to allow the token to open a tunnel on example.ngrok.io your ACL would include the rule <code>bind:example.ngrok.io</code>. Bind rules may specify a leading wildcard to match multiple domains with a common suffix. For example, you may specify a rule of <code>bind:*.example.com</code> which will allow <code>x.example.com</code>, <code>y.example.com</code>, <code>*.example.com</code>, etc. A rule of <code>'*'</code> is equivalent to no acl at all and will explicitly permit all actions.</p>
</td>
	</tr>

</table>
<h6>ssh_public_key_deleted.v0</h6>
<p>Triggers when an SSH public key is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique ssh credential resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the ssh credential API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the ssh credential was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of who or what will use the ssh credential to authenticate. Optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this ssh credential. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>the PEM-encoded public key of the SSH keypair that will be used to authenticate</p>
</td>
	</tr><tr>
		<td>acl</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>optional list of ACL rules. If unspecified, the credential will have no restrictions. The only allowed ACL rule at this time is the <code>bind</code> rule. The <code>bind</code> rule allows the caller to restrict what domains and addresses the token is allowed to bind. For example, to allow the token to open a tunnel on example.ngrok.io your ACL would include the rule <code>bind:example.ngrok.io</code>. Bind rules may specify a leading wildcard to match multiple domains with a common suffix. For example, you may specify a rule of <code>bind:*.example.com</code> which will allow <code>x.example.com</code>, <code>y.example.com</code>, <code>*.example.com</code>, etc. A rule of <code>'*'</code> is equivalent to no acl at all and will explicitly permit all actions.</p>
</td>
	</tr>

</table>
<h6>ssh_public_key_updated.v0</h6>
<p>Triggers when an SSH public key is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique ssh credential resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the ssh credential API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the ssh credential was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of who or what will use the ssh credential to authenticate. Optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this ssh credential. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>the PEM-encoded public key of the SSH keypair that will be used to authenticate</p>
</td>
	</tr><tr>
		<td>acl</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>optional list of ACL rules. If unspecified, the credential will have no restrictions. The only allowed ACL rule at this time is the <code>bind</code> rule. The <code>bind</code> rule allows the caller to restrict what domains and addresses the token is allowed to bind. For example, to allow the token to open a tunnel on example.ngrok.io your ACL would include the rule <code>bind:example.ngrok.io</code>. Bind rules may specify a leading wildcard to match multiple domains with a common suffix. For example, you may specify a rule of <code>bind:*.example.com</code> which will allow <code>x.example.com</code>, <code>y.example.com</code>, <code>*.example.com</code>, etc. A rule of <code>'*'</code> is equivalent to no acl at all and will explicitly permit all actions.</p>
</td>
	</tr>

</table>
<h6>ssh_user_certificate_created.v0</h6>
<p>Triggers when an SSH user certificate is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this SSH User Certificate</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the SSH User Certificate API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the SSH User Certificate API resource was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this SSH User Certificate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this SSH User Certificate. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>a public key in OpenSSH Authorized Keys format that this certificate signs</p>
</td>
	</tr><tr>
		<td>key_type</td>
		<td>string</td>
		<td></td>
		<td><p>the key type of the <code>public_key</code>, one of <code>rsa</code>, <code>ecdsa</code> or <code>ed25519</code></p>
</td>
	</tr><tr>
		<td>ssh_certificate_authority_id</td>
		<td>string</td>
		<td></td>
		<td><p>the ssh certificate authority that is used to sign this ssh user certificate</p>
</td>
	</tr><tr>
		<td>principals</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>the list of principals included in the ssh user certificate. This is the list of usernames that the certificate holder may sign in as on a machine authorizinig the signing certificate authority. Dangerously, if no principals are specified, this certificate may be used to log in as any user.</p>
</td>
	</tr><tr>
		<td>critical_options</td>
		<td>Map&lt;string, string&gt;</td>
		<td></td>
		<td><p>A map of critical options included in the certificate. Only two critical options are currently defined by OpenSSH: <code>force-command</code> and <code>source-address</code>. See <a href="https://github.com/openssh/openssh-portable/blob/master/PROTOCOL.certkeys">the OpenSSH certificate protocol spec</a> for additional details.</p>
</td>
	</tr><tr>
		<td>extensions</td>
		<td>Map&lt;string, string&gt;</td>
		<td></td>
		<td><p>A map of extensions included in the certificate. Extensions are additional metadata that can be interpreted by the SSH server for any purpose. These can be used to permit or deny the ability to open a terminal, do port forwarding, x11 forwarding, and more. If unspecified, the certificate will include limited permissions with the following extension map: <code>{&quot;permit-pty&quot;: &quot;&quot;, &quot;permit-user-rc&quot;: &quot;&quot;}</code> OpenSSH understands a number of predefined extensions. See <a href="https://github.com/openssh/openssh-portable/blob/master/PROTOCOL.certkeys">the OpenSSH certificate protocol spec</a> for additional details.</p>
</td>
	</tr><tr>
		<td>valid_after</td>
		<td>string</td>
		<td></td>
		<td><p>the time when the ssh host certificate becomes valid, in RFC 3339 format.</p>
</td>
	</tr><tr>
		<td>valid_until</td>
		<td>string</td>
		<td></td>
		<td><p>the time after which the ssh host certificate becomes invalid, in RFC 3339 format. the OpenSSH certificates RFC calls this <code>valid_before</code>.</p>
</td>
	</tr><tr>
		<td>certificate</td>
		<td>string</td>
		<td></td>
		<td><p>the signed SSH certificate in OpenSSH Authorized Keys Format. this value should be placed in a <code>-cert.pub</code> certificate file on disk that should be referenced in your <code>sshd_config</code> configuration file with a <code>HostCertificate</code> directive</p>
</td>
	</tr>

</table>
<h6>ssh_user_certificate_deleted.v0</h6>
<p>Triggers when an SSH user certificate is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this SSH User Certificate</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the SSH User Certificate API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the SSH User Certificate API resource was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this SSH User Certificate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this SSH User Certificate. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>a public key in OpenSSH Authorized Keys format that this certificate signs</p>
</td>
	</tr><tr>
		<td>key_type</td>
		<td>string</td>
		<td></td>
		<td><p>the key type of the <code>public_key</code>, one of <code>rsa</code>, <code>ecdsa</code> or <code>ed25519</code></p>
</td>
	</tr><tr>
		<td>ssh_certificate_authority_id</td>
		<td>string</td>
		<td></td>
		<td><p>the ssh certificate authority that is used to sign this ssh user certificate</p>
</td>
	</tr><tr>
		<td>principals</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>the list of principals included in the ssh user certificate. This is the list of usernames that the certificate holder may sign in as on a machine authorizinig the signing certificate authority. Dangerously, if no principals are specified, this certificate may be used to log in as any user.</p>
</td>
	</tr><tr>
		<td>critical_options</td>
		<td>Map&lt;string, string&gt;</td>
		<td></td>
		<td><p>A map of critical options included in the certificate. Only two critical options are currently defined by OpenSSH: <code>force-command</code> and <code>source-address</code>. See <a href="https://github.com/openssh/openssh-portable/blob/master/PROTOCOL.certkeys">the OpenSSH certificate protocol spec</a> for additional details.</p>
</td>
	</tr><tr>
		<td>extensions</td>
		<td>Map&lt;string, string&gt;</td>
		<td></td>
		<td><p>A map of extensions included in the certificate. Extensions are additional metadata that can be interpreted by the SSH server for any purpose. These can be used to permit or deny the ability to open a terminal, do port forwarding, x11 forwarding, and more. If unspecified, the certificate will include limited permissions with the following extension map: <code>{&quot;permit-pty&quot;: &quot;&quot;, &quot;permit-user-rc&quot;: &quot;&quot;}</code> OpenSSH understands a number of predefined extensions. See <a href="https://github.com/openssh/openssh-portable/blob/master/PROTOCOL.certkeys">the OpenSSH certificate protocol spec</a> for additional details.</p>
</td>
	</tr><tr>
		<td>valid_after</td>
		<td>string</td>
		<td></td>
		<td><p>the time when the ssh host certificate becomes valid, in RFC 3339 format.</p>
</td>
	</tr><tr>
		<td>valid_until</td>
		<td>string</td>
		<td></td>
		<td><p>the time after which the ssh host certificate becomes invalid, in RFC 3339 format. the OpenSSH certificates RFC calls this <code>valid_before</code>.</p>
</td>
	</tr><tr>
		<td>certificate</td>
		<td>string</td>
		<td></td>
		<td><p>the signed SSH certificate in OpenSSH Authorized Keys Format. this value should be placed in a <code>-cert.pub</code> certificate file on disk that should be referenced in your <code>sshd_config</code> configuration file with a <code>HostCertificate</code> directive</p>
</td>
	</tr>

</table>
<h6>ssh_user_certificate_updated.v0</h6>
<p>Triggers when an SSH user certificate is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this SSH User Certificate</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the SSH User Certificate API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the SSH User Certificate API resource was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this SSH User Certificate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this SSH User Certificate. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>public_key</td>
		<td>string</td>
		<td></td>
		<td><p>a public key in OpenSSH Authorized Keys format that this certificate signs</p>
</td>
	</tr><tr>
		<td>key_type</td>
		<td>string</td>
		<td></td>
		<td><p>the key type of the <code>public_key</code>, one of <code>rsa</code>, <code>ecdsa</code> or <code>ed25519</code></p>
</td>
	</tr><tr>
		<td>ssh_certificate_authority_id</td>
		<td>string</td>
		<td></td>
		<td><p>the ssh certificate authority that is used to sign this ssh user certificate</p>
</td>
	</tr><tr>
		<td>principals</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>the list of principals included in the ssh user certificate. This is the list of usernames that the certificate holder may sign in as on a machine authorizinig the signing certificate authority. Dangerously, if no principals are specified, this certificate may be used to log in as any user.</p>
</td>
	</tr><tr>
		<td>critical_options</td>
		<td>Map&lt;string, string&gt;</td>
		<td></td>
		<td><p>A map of critical options included in the certificate. Only two critical options are currently defined by OpenSSH: <code>force-command</code> and <code>source-address</code>. See <a href="https://github.com/openssh/openssh-portable/blob/master/PROTOCOL.certkeys">the OpenSSH certificate protocol spec</a> for additional details.</p>
</td>
	</tr><tr>
		<td>extensions</td>
		<td>Map&lt;string, string&gt;</td>
		<td></td>
		<td><p>A map of extensions included in the certificate. Extensions are additional metadata that can be interpreted by the SSH server for any purpose. These can be used to permit or deny the ability to open a terminal, do port forwarding, x11 forwarding, and more. If unspecified, the certificate will include limited permissions with the following extension map: <code>{&quot;permit-pty&quot;: &quot;&quot;, &quot;permit-user-rc&quot;: &quot;&quot;}</code> OpenSSH understands a number of predefined extensions. See <a href="https://github.com/openssh/openssh-portable/blob/master/PROTOCOL.certkeys">the OpenSSH certificate protocol spec</a> for additional details.</p>
</td>
	</tr><tr>
		<td>valid_after</td>
		<td>string</td>
		<td></td>
		<td><p>the time when the ssh host certificate becomes valid, in RFC 3339 format.</p>
</td>
	</tr><tr>
		<td>valid_until</td>
		<td>string</td>
		<td></td>
		<td><p>the time after which the ssh host certificate becomes invalid, in RFC 3339 format. the OpenSSH certificates RFC calls this <code>valid_before</code>.</p>
</td>
	</tr><tr>
		<td>certificate</td>
		<td>string</td>
		<td></td>
		<td><p>the signed SSH certificate in OpenSSH Authorized Keys Format. this value should be placed in a <code>-cert.pub</code> certificate file on disk that should be referenced in your <code>sshd_config</code> configuration file with a <code>HostCertificate</code> directive</p>
</td>
	</tr>

</table>
<h6>tcp_address_created.v0</h6>
<p>Triggers when a TCP address is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique reserved address resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the reserved address API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the reserved address was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of what this reserved address will be used for</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this reserved address. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>addr</td>
		<td>string</td>
		<td></td>
		<td><p>hostname:port of the reserved address that was assigned at creation time</p>
</td>
	</tr><tr>
		<td>region</td>
		<td>string</td>
		<td></td>
		<td><p>reserve the address in this geographic ngrok datacenter. Optional, default is us. (au, eu, ap, us, jp, in, sa)</p>
</td>
	</tr>

</table>
<h6>tcp_address_deleted.v0</h6>
<p>Triggers when a TCP address is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique reserved address resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the reserved address API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the reserved address was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of what this reserved address will be used for</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this reserved address. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>addr</td>
		<td>string</td>
		<td></td>
		<td><p>hostname:port of the reserved address that was assigned at creation time</p>
</td>
	</tr><tr>
		<td>region</td>
		<td>string</td>
		<td></td>
		<td><p>reserve the address in this geographic ngrok datacenter. Optional, default is us. (au, eu, ap, us, jp, in, sa)</p>
</td>
	</tr>

</table>
<h6>tcp_address_updated.v0</h6>
<p>Triggers when a TCP address is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique reserved address resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the reserved address API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the reserved address was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of what this reserved address will be used for</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this reserved address. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>addr</td>
		<td>string</td>
		<td></td>
		<td><p>hostname:port of the reserved address that was assigned at creation time</p>
</td>
	</tr><tr>
		<td>region</td>
		<td>string</td>
		<td></td>
		<td><p>reserve the address in this geographic ngrok datacenter. Optional, default is us. (au, eu, ap, us, jp, in, sa)</p>
</td>
	</tr>

</table>
<h6>tcp_connection_closed.v0</h6>
<p>Triggers when a TCP connection to an endpoint closes.</p>
<p>
This event type supports filters and selectable fields.
</p>
<table class="table"><tr>
		<td>conn.client_ip</td>
		<td>string</td>
		<td>filterable</td>
		<td><p>The source IP of the TCP connection to the ngrok edge</p>
</td>
	</tr><tr>
		<td>conn.end_ts</td>
		<td>timestamp</td>
		<td></td>
		<td><p>The timestamp when the TCP connection to the ngrok edge is closed</p>
</td>
	</tr><tr>
		<td>conn.server_ip</td>
		<td>string</td>
		<td>filterable</td>
		<td><p>The IP address of the server that received the request</p>
</td>
	</tr><tr>
		<td>conn.server_name</td>
		<td>string</td>
		<td>filterable</td>
		<td><p>The hostname associated with this connection.</p>
</td>
	</tr><tr>
		<td>conn.server_port</td>
		<td>int32</td>
		<td>filterable</td>
		<td><p>The port that the connection for this request came in on</p>
</td>
	</tr><tr>
		<td>conn.start_ts</td>
		<td>timestamp</td>
		<td></td>
		<td><p>The timestamp when the TCP connection to the ngrok edge is established</p>
</td>
	</tr><tr>
		<td>ip_policy.decision</td>
		<td>string</td>
		<td></td>
		<td><p>&lsquo;allow&rsquo; if IP Policy module permitted the request to the upstream service, &lsquo;block&rsquo; otherwise</p>
</td>
	</tr>
</table>
<h6>tls_certificate_created.v0</h6>
<p>Triggers when a TLS certificate is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this TLS certificate</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the TLS certificate API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the TLS certificate was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this TLS certificate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this TLS certificate. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>certificate_pem</td>
		<td>string</td>
		<td></td>
		<td><p>chain of PEM-encoded certificates, leaf first. See <a href="https://ngrok.com/docs/api#tls-certificates-pem">Certificate Bundles</a>.</p>
</td>
	</tr><tr>
		<td>subject_common_name</td>
		<td>string</td>
		<td></td>
		<td><p>subject common name from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_alternative_names.dns_names</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of additional domains (including wildcards) this TLS certificate is valid for</p>
</td>
	</tr><tr>
		<td>subject_alternative_names.ips</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of IP addresses this TLS certificate is also valid for</p>
</td>
	</tr><tr>
		<td>issued_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp (in RFC 3339 format) when this TLS certificate was issued automatically, or null if this certificate was user-uploaded</p>
</td>
	</tr><tr>
		<td>not_before</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this TLS certificate becomes valid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>not_after</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this TLS certificate becomes invalid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of actions the private key of this TLS certificate can be used for</p>
</td>
	</tr><tr>
		<td>extended_key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>extended set of actions the private key of this TLS certificate can be used for</p>
</td>
	</tr><tr>
		<td>private_key_type</td>
		<td>string</td>
		<td></td>
		<td><p>type of the private key of this TLS certificate. One of rsa, ecdsa, or ed25519.</p>
</td>
	</tr><tr>
		<td>issuer_common_name</td>
		<td>string</td>
		<td></td>
		<td><p>issuer common name from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>serial_number</td>
		<td>string</td>
		<td></td>
		<td><p>serial number of the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_organization</td>
		<td>string</td>
		<td></td>
		<td><p>subject organization from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_organizational_unit</td>
		<td>string</td>
		<td></td>
		<td><p>subject organizational unit from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_locality</td>
		<td>string</td>
		<td></td>
		<td><p>subject locality from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_province</td>
		<td>string</td>
		<td></td>
		<td><p>subject province from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_country</td>
		<td>string</td>
		<td></td>
		<td><p>subject country from the leaf of this TLS certificate</p>
</td>
	</tr>

</table>
<h6>tls_certificate_deleted.v0</h6>
<p>Triggers when a TLS certificate is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this TLS certificate</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the TLS certificate API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the TLS certificate was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this TLS certificate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this TLS certificate. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>certificate_pem</td>
		<td>string</td>
		<td></td>
		<td><p>chain of PEM-encoded certificates, leaf first. See <a href="https://ngrok.com/docs/api#tls-certificates-pem">Certificate Bundles</a>.</p>
</td>
	</tr><tr>
		<td>subject_common_name</td>
		<td>string</td>
		<td></td>
		<td><p>subject common name from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_alternative_names.dns_names</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of additional domains (including wildcards) this TLS certificate is valid for</p>
</td>
	</tr><tr>
		<td>subject_alternative_names.ips</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of IP addresses this TLS certificate is also valid for</p>
</td>
	</tr><tr>
		<td>issued_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp (in RFC 3339 format) when this TLS certificate was issued automatically, or null if this certificate was user-uploaded</p>
</td>
	</tr><tr>
		<td>not_before</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this TLS certificate becomes valid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>not_after</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this TLS certificate becomes invalid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of actions the private key of this TLS certificate can be used for</p>
</td>
	</tr><tr>
		<td>extended_key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>extended set of actions the private key of this TLS certificate can be used for</p>
</td>
	</tr><tr>
		<td>private_key_type</td>
		<td>string</td>
		<td></td>
		<td><p>type of the private key of this TLS certificate. One of rsa, ecdsa, or ed25519.</p>
</td>
	</tr><tr>
		<td>issuer_common_name</td>
		<td>string</td>
		<td></td>
		<td><p>issuer common name from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>serial_number</td>
		<td>string</td>
		<td></td>
		<td><p>serial number of the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_organization</td>
		<td>string</td>
		<td></td>
		<td><p>subject organization from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_organizational_unit</td>
		<td>string</td>
		<td></td>
		<td><p>subject organizational unit from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_locality</td>
		<td>string</td>
		<td></td>
		<td><p>subject locality from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_province</td>
		<td>string</td>
		<td></td>
		<td><p>subject province from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_country</td>
		<td>string</td>
		<td></td>
		<td><p>subject country from the leaf of this TLS certificate</p>
</td>
	</tr>

</table>
<h6>tls_certificate_updated.v0</h6>
<p>Triggers when a TLS certificate is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique identifier for this TLS certificate</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the TLS certificate API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the TLS certificate was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of this TLS certificate. optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this TLS certificate. optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>certificate_pem</td>
		<td>string</td>
		<td></td>
		<td><p>chain of PEM-encoded certificates, leaf first. See <a href="https://ngrok.com/docs/api#tls-certificates-pem">Certificate Bundles</a>.</p>
</td>
	</tr><tr>
		<td>subject_common_name</td>
		<td>string</td>
		<td></td>
		<td><p>subject common name from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_alternative_names.dns_names</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of additional domains (including wildcards) this TLS certificate is valid for</p>
</td>
	</tr><tr>
		<td>subject_alternative_names.ips</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of IP addresses this TLS certificate is also valid for</p>
</td>
	</tr><tr>
		<td>issued_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp (in RFC 3339 format) when this TLS certificate was issued automatically, or null if this certificate was user-uploaded</p>
</td>
	</tr><tr>
		<td>not_before</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this TLS certificate becomes valid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>not_after</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when this TLS certificate becomes invalid, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>set of actions the private key of this TLS certificate can be used for</p>
</td>
	</tr><tr>
		<td>extended_key_usages</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>extended set of actions the private key of this TLS certificate can be used for</p>
</td>
	</tr><tr>
		<td>private_key_type</td>
		<td>string</td>
		<td></td>
		<td><p>type of the private key of this TLS certificate. One of rsa, ecdsa, or ed25519.</p>
</td>
	</tr><tr>
		<td>issuer_common_name</td>
		<td>string</td>
		<td></td>
		<td><p>issuer common name from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>serial_number</td>
		<td>string</td>
		<td></td>
		<td><p>serial number of the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_organization</td>
		<td>string</td>
		<td></td>
		<td><p>subject organization from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_organizational_unit</td>
		<td>string</td>
		<td></td>
		<td><p>subject organizational unit from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_locality</td>
		<td>string</td>
		<td></td>
		<td><p>subject locality from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_province</td>
		<td>string</td>
		<td></td>
		<td><p>subject province from the leaf of this TLS certificate</p>
</td>
	</tr><tr>
		<td>subject_country</td>
		<td>string</td>
		<td></td>
		<td><p>subject country from the leaf of this TLS certificate</p>
</td>
	</tr>

</table>
<h6>tunnel_credential_created.v0</h6>
<p>Triggers when a tunnel credential is created</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique tunnel credential resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the tunnel credential API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the tunnel credential was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of who or what will use the credential to authenticate. Optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this credential. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>token</td>
		<td>string</td>
		<td></td>
		<td><p>the credential&rsquo;s authtoken that can be used to authenticate an ngrok client. <strong>This value is only available one time, on the API response from credential creation, otherwise it is null.</strong></p>
</td>
	</tr><tr>
		<td>acl</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>optional list of ACL rules. If unspecified, the credential will have no restrictions. The only allowed ACL rule at this time is the <code>bind</code> rule. The <code>bind</code> rule allows the caller to restrict what domains and addresses the token is allowed to bind. For example, to allow the token to open a tunnel on example.ngrok.io your ACL would include the rule <code>bind:example.ngrok.io</code>. Bind rules may specify a leading wildcard to match multiple domains with a common suffix. For example, you may specify a rule of <code>bind:*.example.com</code> which will allow <code>x.example.com</code>, <code>y.example.com</code>, <code>*.example.com</code>, etc. A rule of <code>'*'</code> is equivalent to no acl at all and will explicitly permit all actions.</p>
</td>
	</tr>

</table>
<h6>tunnel_credential_deleted.v0</h6>
<p>Triggers when a tunnel credential is deleted</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique tunnel credential resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the tunnel credential API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the tunnel credential was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of who or what will use the credential to authenticate. Optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this credential. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>token</td>
		<td>string</td>
		<td></td>
		<td><p>the credential&rsquo;s authtoken that can be used to authenticate an ngrok client. <strong>This value is only available one time, on the API response from credential creation, otherwise it is null.</strong></p>
</td>
	</tr><tr>
		<td>acl</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>optional list of ACL rules. If unspecified, the credential will have no restrictions. The only allowed ACL rule at this time is the <code>bind</code> rule. The <code>bind</code> rule allows the caller to restrict what domains and addresses the token is allowed to bind. For example, to allow the token to open a tunnel on example.ngrok.io your ACL would include the rule <code>bind:example.ngrok.io</code>. Bind rules may specify a leading wildcard to match multiple domains with a common suffix. For example, you may specify a rule of <code>bind:*.example.com</code> which will allow <code>x.example.com</code>, <code>y.example.com</code>, <code>*.example.com</code>, etc. A rule of <code>'*'</code> is equivalent to no acl at all and will explicitly permit all actions.</p>
</td>
	</tr>

</table>
<h6>tunnel_credential_updated.v0</h6>
<p>Triggers when a tunnel credential is updated</p>
<p>
This event type does not support filters or selectable fields.
</p>
<table class="table">
<tr>
		<td>id</td>
		<td>string</td>
		<td></td>
		<td><p>unique tunnel credential resource identifier</p>
</td>
	</tr><tr>
		<td>uri</td>
		<td>string</td>
		<td></td>
		<td><p>URI of the tunnel credential API resource</p>
</td>
	</tr><tr>
		<td>created_at</td>
		<td>string</td>
		<td></td>
		<td><p>timestamp when the tunnel credential was created, RFC 3339 format</p>
</td>
	</tr><tr>
		<td>description</td>
		<td>string</td>
		<td></td>
		<td><p>human-readable description of who or what will use the credential to authenticate. Optional, max 255 bytes.</p>
</td>
	</tr><tr>
		<td>metadata</td>
		<td>string</td>
		<td></td>
		<td><p>arbitrary user-defined machine-readable data of this credential. Optional, max 4096 bytes.</p>
</td>
	</tr><tr>
		<td>token</td>
		<td>string</td>
		<td></td>
		<td><p>the credential&rsquo;s authtoken that can be used to authenticate an ngrok client. <strong>This value is only available one time, on the API response from credential creation, otherwise it is null.</strong></p>
</td>
	</tr><tr>
		<td>acl</td>
		<td>List&lt;string&gt;</td>
		<td></td>
		<td><p>optional list of ACL rules. If unspecified, the credential will have no restrictions. The only allowed ACL rule at this time is the <code>bind</code> rule. The <code>bind</code> rule allows the caller to restrict what domains and addresses the token is allowed to bind. For example, to allow the token to open a tunnel on example.ngrok.io your ACL would include the rule <code>bind:example.ngrok.io</code>. Bind rules may specify a leading wildcard to match multiple domains with a common suffix. For example, you may specify a rule of <code>bind:*.example.com</code> which will allow <code>x.example.com</code>, <code>y.example.com</code>, <code>*.example.com</code>, etc. A rule of <code>'*'</code> is equivalent to no acl at all and will explicitly permit all actions.</p>
</td>
	</tr>

</table>
    <h4>Event Destinations</h4>
    <p>An Event Destination specifies a service and any required configuration for it to receive Events data. You can send a set of Events to one or more Destinations. Currently, you can configure your Destinations to send Events to the following services:</p>
      <ul>
        <li>AWS CloudWatch Logs</li>
        <li>AWS Kinesis Data Streams</li>
        <li>AWS Kinesis Firehose Delivery Streams</li>
      </ul>
    <p>Note that Kinesis Firehose can deliver events into an S3 bucket.</p>
    <h3 id="events-payloads">Events Payloads</h3>
    <p>Events are sent as JSON to configured destinations. All events include the following fields:</p>
      <table class="table">
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Example</th>
        </tr>
        <tr>
          <td>event_id</td>
          <td>unique identifier for this event, always prefixed with ev_</td>
          <td><code>ev_1vPlyBW3OR44bpPphS4HIZyajDD</code></td>
        </tr>
        <tr>
          <td>event_type</td>
          <td>identifies the object, action, and version of the event</td>
          <td><code>ip_policy_created.v0</code></td>
        </tr>
        <tr>
          <td>event_timestamp</td>
          <td>timestamp of when the event fired in RFC 3339 format</td>
          <td><code>2021-07-16T21:44:37Z</code></td>
        </tr>
        <tr>
          <td>object</td>
          <td>a json object describing the resource where the event occurred</td>
          <td><code>{<br>
            "id": "ipp_1vPlyF4iyQj82hjSv67dRkV8woI",<br>
            "uri": "https://api.ngrok.com/ip_policies/ipp_1vPlyF4iyQj82hjSv67dRkV8woI",<br>
            "created_at": "2021-07-16T21:44:16Z",<br>
            "description": "bar",<br>
            "metadata": "",<br>
            "action": "allow"<br>
            }</code></td>
        </tr>
      </table>

    <h2 id="global">Global infrastructure</h2>
    <p>ngrok runs globally distributed tunnel servers around the world to enable fast, low latency traffic
  to your applications.
    </p>
    <h3 id="global-locations">Locations</h3>
    <p>ngrok runs tunnel servers in datacenters around the world. The location of the datacenter within
  a given region may change without notice (e.g. the European servers may move from Frankfurt to London).
    </p>
    <ul>
      <li>
        <h5>us - United States <small>(Ohio)</small></h5>
      </li>
      <li>
        <h5>eu - Europe <small>(Frankfurt)</small></h5>
      </li>
      <li>
        <h5>ap - Asia/Pacific <small>(Singapore)</small></h5>
      </li>
      <li>
        <h5>au - Australia <small>(Sydney)</small></h5>
      </li>
      <li>
        <h5>sa - South America <small>(Sao Paulo)</small></h5>
      </li>
      <li>
        <h5>jp - Japan <small>(Tokyo)</small></h5>
      </li>
      <li>
        <h5>in - India <small>(Mumbai)</small></h5>
      </li>
    </ul>
    <h3 id="global-usage">Usage</h3>
    <p><strong>If you do not explicitly pick a region, your tunnel will be hosted in the default region, the United States</strong>. Picking the region
  closest to you is as easy as specifying setting the <code>-region</code> command line flag or setting the <code>region</code> property in your configuration file.
  For example, to start a tunnel in the Europe region:
    </p>
    <div class="well">
      <pre><code>ngrok http -region eu 8080</code></pre>
    </div>
    <p>Reserved domains and reserved addresses are allocated for a specific region (the US region by default). When you reserve a domain
  or address, you must select a target region. You may not bind a domain or address reserved in another region other than the one it
  was allocated for. Attempting to do so will yield an error and prevent your tunnel session from initializing.
    </p>
    <h3 id="global-limitations">Limitations</h3>
    <p><strong>An ngrok client may only be connected a single region</strong>. This may change in the future, but at the moment a single
  ngrok client cannot host tunnels in multiple regions simultaneously. Run multiple ngrok clients if you need to do this.
    </p>
    <p><strong>A domain cannot be reserved for multiple regions simultaneously.</strong> It is not possible to geo-balance DNS
  to the same tunnel name in multiple regions. Use region-specific subdomains or TLDs if you need to do this
  (<code>eu.tunnel.example.com</code>, <code>us.tunnel.example.com</code>, etc).
    </p>

    <h2 id="ssh-gateway">SSH Gateway</h2>
    <p>SSH reverse tunneling is an alternative mechanism to start an ngrok tunnel without even needing to download
    or run the ngrok client. You can start tunnels via SSH without downloading an ngrok client by running an SSH reverse tunnel
    command.
    </p>
    <p>The SSH gateway functionality should not be confused with exposing an SSH server via ngrok. If you want to expose your own SSH
    server for remote access, please refer to the <a href="#tcp">documentation on TCP tunnels</a>.
    </p>
    <h3 id="ssh-gateway-public-key">Uploading a Public Key</h3>
    <p>Before you can start a tunnel via the SSH gateway, you'll need to upload your SSH public key. To upload your SSH public key, open the file
    <code>~/.ssh/id_rsa.pub</code> and copy its contents. Then go to <a href="https://dashboard.ngrok.com/tunnel-agents/ssh-keys">the Auth tab on your dashboard</a> and paste the contents
    into the SSH Key input and optionally enter a human description (like the name of your machine). You should now be able to start SSH tunnels!
    </p>
    <h6 class="muted">Copy your SSH public key on Mac OS X</h6>
    <div class="well">
      <pre><code>cat ~/.ssh/id_rsa.pub | pbcopy</code></pre>
    </div>
    <h6 class="muted">Add your SSH key by pasting it into the ngrok dashboard.</h6>
    <img src="/static/img/add-ssh-key.png" alt="" class="img-polaroid"/>
    <h3 id="ssh-gateway-examples">Examples</h3>
    <p>
    ngrok tries to honor the syntax of <code>ssh -R</code> for all of the tunnel commands in its SSH gateway. You may wish to consult <code>man ssh</code>,
    and the section devoted to the <code>-R</code> option for additional details. ngrok uses additional command line options to implement features that are
    not otherwise available via the <code>-R</code> syntax.
    </p>
    <p>
    The following examples demonstrate how to use the SSH gateway and provide the equivalent ngrok client command to help
    you best understand how to achieve similar functionality.
    </p>

    <h6 class="muted">Start an http tunnel forwarding to port 80</h6>
    <div class="well">
      <pre><code><span class="equivalent"># equivalent: `ngrok http 80`</span>
ssh -R 80:localhost:80 tunnel.us.ngrok.com http</code></pre>
    </div>
    <h6 class="muted">Start an http tunnel on a custom subdomain forwarding to port 8080</h6>
    <div class="well">
      <pre><code><span class="equivalent"># equivalent: `ngrok http -subdomain=custom-subdomain 8080`</span>
ssh -R custom-subdomain.ngrok.io:80:localhost:8080 tunnel.us.ngrok.com http</code></pre>
    </div>
    <h6 class="muted">Start an http tunnel on a custom domain with auth</h6>
    <div class="well">
      <pre><code><span class="equivalent"># equivalent: `ngrok http -hostname=example.com 8080`</span>
ssh -R example.com:80:localhost:8080 tunnel.us.ngrok.com http -auth="user:password"</code></pre>
    </div>
    <h6 class="muted">Start a TCP tunnel</h6>
    <div class="well">
      <pre><code><span class="equivalent"># equivalent: `ngrok tcp 22`</span>
ssh -R 0:localhost:22 tunnel.us.ngrok.com tcp 22</code></pre>
    </div>
    <h6 class="muted">Start a TCP tunnel on a reserved address</h6>
    <div class="well">
      <pre><code><span class="equivalent"># equivalent: `ngrok tcp --remote-addr=1.tcp.ngrok.io:24313 22`</span>
ssh -R 1.tcp.ngrok.io:24313:localhost:22 tunnel.us.ngrok.com tcp</code></pre>
    </div>
    <h6 class="muted">Start a TLS tunnel</h6>
    <div class="well">
      <pre><code><span class="equivalent" style="color: #aaa"># equivalent: `ngrok tls 8443`</span>
ssh -R 443:localhost:8443 tunnel.us.ngrok.com tls</code></pre>
    </div>
    <h6 class="muted">Start a tunnel in a different region</h6>
    <div class="well">
      <pre><code><span class="equivalent" style="color: #aaa"># equivalent: `ngrok http -region=eu 80`</span>
ssh -R 80:localhost:80 tunnel.eu.ngrok.com http</code></pre>
    </div>

    <h2 id="using-ngrok-with">Using ngrok with &#8230;</h2>
    <h3 id="wordpress">Wordpress</h3>
    <p>
      To make ngrok work properly with Wordpress installations you usually need to do two things:
      <ol>
        <li>
          You must ensure that Wordpress issues relative URLS. You can do so by installing the following plugin:</li>
          <ul>
            <li>
              <a href="http://wordpress.org/plugins/relative-url/">
              http://wordpress.org/plugins/relative-url/</a>
            </li>
          </ul>
        </li>
        <li>
          You must ensure that Wordpress understands that it is meant to serve itself from your tunneled hostname. You can configure
          Wordpress to do that by modifying your `wp-config` to include the following lines:
          <br />
          <div class="well">
            <pre><code>define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST']);
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST']);</pre></code>
          </div>
        </li>
        <li>
          You must also instruct ngrok to <a href="#http-host-header">rewrite the host header</a>, like so:
          <pre><code>ngrok http -host-header=rewrite https://your-site.dev</code></pre>
        </li>
      </ol>
    </p>
    <h3 id="virtual-hosts">Virtual hosts (MAMP, WAMP, etc)</h3>
    <p>
      Popular web servers such as MAMP and WAMP rely on a technique popularly referred to as 'Virtual Hosting' which means that they consult the HTTP request's <code>Host</code>
      header to determine which of their multiple sites they should serve. To expose a site like this it is possible to ask ngrok to rewrite the <code>Host</code> header
      of all tunneled requests to match what your web server expects. You can do this by using the <code>-host-header</code> option (see: <a href="#host-header">Rewriting the Host header</a>)
      to pick which virtual host you want to target. For example, to route to your local site <code>myapp.dev</code>, you would run:
      <pre><code>ngrok http -host-header=myapp.dev 80</code></pre>
    </p>
    <h3 id="visual-studio">Visual Studio / IIS Express</h3>
    <p>
      Use dproterho's visual studio extension which adds ngrok support directly into Visual Studio:
      <a href="https://marketplace.visualstudio.com/items?itemName=DavidProthero.NgrokExtensions">ngrok extension for Visual Studio</a>
    </p>
    <h3 id="vscode">VSCode</h3>
    <p>
      Use nash's VSCode extension which adds ngrok support directly into VSCode:
      <a href="https://marketplace.visualstudio.com/items?itemName=philnash.ngrok-for-vscode">ngrok extension for VSCode</a>
    </p>
    <h3 id="outbound-proxy">An outbound proxy</h3>
    <p>
      ngrok works correctly through an HTTP or SOCKS5 proxy. ngrok respects the standard unix environment variable <code>http_proxy</code>. You may also set proxy
      configuration explicitly in the ngrok configuration file:
      <ul>
        <li><a href="#config_http_proxy">Set the configuration variable <code>http_proxy</code></a></li>
        <li><a href="#config_socks5_proxy">Set the configuration varible <code>socks5_proxy</code></a></li>
      </ul>
    </p>
    <h3 id="nodejs">node.js</h3>
    <p>
      Use bubenshchykov's npm package for interacting with ngrok from node.js:
      <ul>
        <li><a href="https://www.npmjs.com/package/ngrok">ngrok module on npm</a></li>
        <li><a href="https://github.com/bubenshchykov/ngrok">ngrok npm module on github</a></li>
      </ul>
    </p>
    <h3 id="puppet">Puppet</h3>
    <p>
      Use gabe's puppet module for installing and configuring ngrok resources and ensure the ngrok client process is running:
      <a href="https://forge.puppet.com/gabe/ngrok">ngrok module for Puppet</a>
    </p>
    <h2 id="troubleshooting">Troubleshooting</h2>
    <h3 id="cors-basic-auth">CORS with HTTP basic authentication</h3>
    <p>
      Yes, but you cannot use ngrok's <code>-auth</code> option. ngrok's http tunnels allow you to specify basic authentication credentials to protect your tunnels. However, ngrok enforces this policy on *all* requests, including the preflight <code>OPTIONS</code> requests that are required by the CORS spec. In this case, your application must implement its own basic authentication. For more details, see <a href="https://github.com/inconshreveable/ngrok/issues/196">this github issue</a>.
    </p>
    <h2 id="client-api">ngrok Agent API</h2>
    <p>The ngrok client exposes an HTTP API that grants programmatic access to:</p>
    <ul>
      <li>Collect status and metrics information</li>
      <li>Collect and replay captured requests</li>
      <li>Start and stop tunnels dynamically</li>
    </ul>
    <h3 id="client-api-base">Base URL and Authentication</h3>
    <table class="table">
      <tr>
        <th>Base URL</th>
        <td><code>http://127.0.0.1:4040/api</code>
        </td>
      </tr>
      <tr>
        <th>Authentication</th>
        <td><strong>None</strong>
        </td>
      </tr>
    </table>
    <p>The ngrok agent API is exposed as part of ngrok's local web inspection interface. Because it is served on a local interface,
  the API has no authentication. The Base URL will change if you override <code>web_addr</code> in your configuration file.
    </p>
    <h6 class="muted">Access the root API resource of a running ngrok client</h6>
    <div class="well">
      <pre><code>curl http://localhost:4040/api/</code></pre>
    </div>
    <h3 id="client-api-content-type">Supported Content Types</h3>
    <p>Request parameters must be encoded to the API using <code>application/json</code>.
  Ensure that your client sets the request's <code>Content-Type</code> header appropriately.
  All responses returned by the API are <code>application/json</code>.
    </p>
    <h3 id="api-versioning">Versioning and API Stability</h3>
    <p>The ngrok agent API guarantees that breaking changes to the API will never be made unless the caller explicitly opts in to a newer version.
  The mechanism by which a caller opts into a new version of the API will be determined in the future when it becomes necessary.
  Examples of non-breaking changes to the API that will not be opt-in include the following.
    </p>
    <ul>
      <li>The addition of new resources</li>
      <li>The addition of new methods to existing resources</li>
      <li>The addition of new fields on existing resource representations</li>
      <li>Bug fixes which change the API to match documented behavior</li>
    </ul>
    <div class="api">
      <h3 id="list-tunnels">List Tunnels</h3>
      <p>Returns a list of running tunnels with status and metrics information.</p>
      <h5>Request</h5>
      <div class="endpoint"><span class="verb">GET</span><span class="path">/api/tunnels</span>
      </div>
      <h5>Response</h5>
      <h6>Parameters</h6>
      <table class="table">
        <tr>
          <th><code>tunnels</code>
          </th>
          <td>list of all running tunnels. See the <a href="#tunnel-detail">Tunnel detail</a> resource for docs on the parameters of each tunnel object</td>
        </tr>
      </table>
      <h6>Example Response</h6>
      <div class="well">
        <pre><code>{
  "tunnels": [
      {
          "name": "command_line",
          "uri": "/api/tunnels/command_line",
          "public_url": "https://d95211d2.ngrok.io",
          "proto": "https",
          "config": {
              "addr": "localhost:80",
              "inspect": true,
          },
          "metrics": {
              "conns": {
                  "count": 0,
                  "gauge": 0,
                  "rate1": 0,
                  "rate5": 0,
                  "rate15": 0,
                  "p50": 0,
                  "p90": 0,
                  "p95": 0,
                  "p99": 0
              },
              "http": {
                  "count": 0,
                  "rate1": 0,
                  "rate5": 0,
                  "rate15": 0,
                  "p50": 0,
                  "p90": 0,
                  "p95": 0,
                  "p99": 0
              }
          }
      },
      ...
  ],
  "uri": "/api/tunnels"
}</code></pre>
      </div>
      <h3 id="start-tunnel">Start tunnel</h3>
      <p>Dynamically starts a new tunnel on the ngrok client. The request body parameters are the same as those you would
  use to define the tunnel in the configuration file.
      </p>
      <h5>Request</h5>
      <div class="endpoint"><span class="verb">POST</span><span class="path">/api/tunnels</span>
      </div>
      <h6>Parameters</h6>
      <p>Parameter names and behaviors are identical to those those defined in the configuration file.
  Use the <a href="#tunnel-definitions">tunnel definitions</a> section as a reference for configuration
  parameters and their behaviors.
      </p>
      <h6>Example request body</h6>
      <div class="well">
        <pre><code>{
  "addr": "22",
  "proto": "tcp",
  "name": "ssh"
}</code></pre>
      </div>
      <h5>Response</h5>
      <p>201 status code with a response body describing the started tunnel.
  See the <a href="#tunnel-detail">Tunnel detail</a> resource for docs on the parameters of the response object
      </p>
      <h6>Example Response</h6>
      <div class="well">
        <pre><code>{
  "name": "",
  "uri": "/api/tunnels/",
  "public_url": "tcp://0.tcp.ngrok.io:53476",
  "proto": "tcp",
  "config": {
      "addr": "localhost:22",
      "inspect": false,
  },
  "metrics": {
      "conns": {
          "count": 0,
          "gauge": 0,
          "rate1": 0,
          "rate5": 0,
          "rate15": 0,
          "p50": 0,
          "p90": 0,
          "p95": 0,
          "p99": 0
      },
      "http": {
          "count": 0,
          "rate1": 0,
          "rate5": 0,
          "rate15": 0,
          "p50": 0,
          "p90": 0,
          "p95": 0,
          "p99": 0
      }
  }
}</code></pre>
      </div>
      <h3 id="tunnel-detail">Tunnel detail</h3>
      <p>Get status and metrics about the named running tunnel</p>
      <h5>Request</h5>
      <div class="endpoint"><span class="verb">GET</span><span class="path">/api/tunnels/:name</span>
      </div>
      <h5>Response</h5>
      <h6>Example Response</h6>
      <div class="well">
        <pre><code>{
  "name": "command_line",
  "uri": "/api/tunnels/command_line",
  "public_url": "https://ac294125.ngrok.io",
  "proto": "https",
  "config": {
      "addr": "localhost:80",
      "inspect": true,
  },
  "metrics": {
      "conns": {
          "count": 0,
          "gauge": 0,
          "rate1": 0,
          "rate5": 0,
          "rate15": 0,
          "p50": 0,
          "p90": 0,
          "p95": 0,
          "p99": 0
      },
      "http": {
          "count": 0,
          "rate1": 0,
          "rate5": 0,
          "rate15": 0,
          "p50": 0,
          "p90": 0,
          "p95": 0,
          "p99": 0
      }
  }
}</code></pre>
      </div>
      <h3 id="stop-tunnel">Stop tunnel</h3>
      <p>Stop a running tunnel</p>
      <h5>Request</h5>
      <div class="endpoint"><span class="verb">DELETE</span><span class="path">/api/tunnels/:name</span>
      </div>
      <h5>Response</h5>
      <p>204 status code with an empty body</p>
      <h3 id="list-requests">List Captured Requests</h3>
      <p>Returns a list of all HTTP requests captured for inspection. This will only return requests
  that are still in memory (ngrok evicts captured requests when their memory usage exceeds <code>inspect_db_size</code>)
      </p>
      <h5>Request</h5>
      <div class="endpoint"><span class="verb">GET</span><span class="path">/api/requests/http</span>
      </div>
      <h6>Query Parameters</h6>
      <table class="table">
        <tr>
          <th><code>limit</code>
          </th>
          <td>maximum number of requests to return</td>
        </tr>
        <tr>
          <th><code>tunnel_name</code>
          </th>
          <td>filter requests only for the given tunnel name</td>
        </tr>
      </table>
      <h6>Example Request</h6>
      <div class="well">
        <pre><code>curl http://localhost:4040/api/requests/http?limit=50</code></pre></code>
        </pre>
      </div>
      <h5>Response</h5>
      <table class="table">
        <tr>
          <th><code>requests</code>
          </th>
          <td>list of captured requests. See the <a href="#request-detail">Captured Request Detail</a> resource for docs on the request objects</td>
        </tr>
      </table>
      <h6>Example Response</h6>
      <div class="well">
        <pre><code>{
  "uri": "/api/requests/http",
  "requests": [
      {
          "uri": "/api/requests/http/548fb5c700000002",
          "id": "548fb5c700000002",
          "tunnel_name": "command_line (http)",
          "remote_addr": "192.168.100.25",
          "start": "2014-12-15T20:32:07-08:00",
          "duration": 3893202,
          "request": {
              "method": "GET",
              "proto": "HTTP/1.1",
              "headers": {
                  "Accept": [
                      "*/*"
                  ],
                  "Accept-Encoding": [
                      "gzip, deflate, sdch"
                  ],
                  "Accept-Language": [
                      "en-US,en;q=0.8"
                  ],
                  "Connection": [
                      "keep-alive"
                  ],
                  "User-Agent": [
                      "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36"
                  ],
                  "X-Original-Host": [
                      "c159663f.ngrok.io"
                  ]
              },
              "uri": "/favicon.ico",
              "raw": "<BASE64 ENCODED BYTES>"
          },
          "response": {
              "status": "502 Bad Gateway",
              "status_code": 502,
              "proto": "HTTP/1.1",
              "headers": {
                  "Content-Length": [
                      "1716"
                  ]
              },
              "raw": "<BASE64 ENCODED BYTES>",
          }
      },
      ...
  ]
}</code></pre>
      </div>
      <h3 id="replay-request">Replay Captured Request</h3>
      <p>Replays a request against the local endpoint of a tunnel</p>
      <h5>Request</h5>
      <div class="endpoint"><span class="verb">POST</span><span class="path">/api/requests/http</span>
      </div>
      <h6>Parameters</h6>
      <table class="table">
        <tr>
          <th><code>id</code>
          </th>
          <td>id of request to replay</td>
        </tr>
        <tr>
          <th><code>tunnel_name</code>
          </th>
          <td>name of the tunnel to play the request against. If unspecified, the request is played against the same tunnel it was recorded on</td>
        </tr>
      </table>
      <h6>Example Request</h6>
      <div class="well">
        <pre><code>curl -H "Content-Type: application/json" -d '{"id": "548fb5c700000002"}' http://localhost:4040/api/requests/http</code></pre></code>
        </pre>
      </div>
      <h5>Response</h5>
      <p>204 status code with an empty body</p>
      <h3 id="delete-requests">Delete Captured Requests</h3>
      <p>Deletes all captured requests</p>
      <h5>Request</h5>
      <div class="endpoint"><span class="verb">DELETE</span><span class="path">/api/requests/http</span>
      </div>
      <h5>Response</h5>
      <p>204 status code with no response body</p>
      <h3 id="request-detail">Captured Request Detail</h3>
      <p>Returns metadata and raw bytes of a captured request. The raw data is base64-encoded in the JSON response.
  The <code>response</code> value maybe <code>null</code> if the local server has not yet responded to a request.
      </p>
      <h5>Request</h5>
      <div class="endpoint"><span class="verb">GET</span><span class="path">/api/requests/http/:request_id</span>
      </div>
      <h5>Response</h5>
      <h6>Example Response</h6>
      <div class="well">
        <pre><code>{
  "uri": "/api/requests/http/548fb5c700000002",
  "id": "548fb5c700000002",
  "tunnel_name": "command_line (http)",
  "remote_addr": "192.168.100.25",
  "start": "2014-12-15T20:32:07-08:00",
  "duration": 3893202,
  "request": {
      "method": "GET",
      "proto": "HTTP/1.1",
      "headers": {
          "Accept": [
              "*/*"
          ],
          "Accept-Encoding": [
              "gzip, deflate, sdch"
          ],
          "Accept-Language": [
              "en-US,en;q=0.8"
          ],
          "Connection": [
              "keep-alive"
          ],
          "User-Agent": [
              "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36"
          ],
          "X-Original-Host": [
              "c159663f.ngrok.io"
          ]
      },
      "uri": "/favicon.ico",
      "raw": "<BASE64 ENCODED BYTES>"
  },
  "response": {
      "status": "502 Bad Gateway",
      "status_code": 502,
      "proto": "HTTP/1.1",
      "headers": {
          "Content-Length": [
              "1716"
          ]
      },
      "raw": "<BASE64 ENCODED BYTES>",
  }
}</code></pre>
      </div>
    </div>
    <h2 id="ngrok-rest-api">ngrok HTTP API</h2>
    <p>We expose an HTTP API that grants programmatic access to
      all of ngrok's resources.</p>
    <p>A basic understanding of ngrok and its features is strongly encouraged before using this API:
      <a href="/docs/api">the ngrok.com HTTP API</a>.
    </p>
    <p>
      This HTTP API is part of our Beta suite of features and any user subscribed to a paid ngrok plan can request access. Please note, we may be charging for some features in our Beta suite once they are officially released.
    </p>

    <h2 id="errors">Errors</h2>
    <p>When something goes wrong, we report an error code: in the agent, our REST API, or
    at our edge.</p>
    <p>You can see a comprehensive list of those errors
      <a href="/docs/errors">in our error index</a>.
    </p>

    <h2 id="ngrok-guides">Guides</h2>
    <p>We have written some guides to walk you through some common workflows.</p>
    <ul>
      <li><a href="/docs/guides/quickstart">Quickstart Guide</a></li>
      <li><a href="/docs/guides/how-to-set-up-a-custom-domain">How to Set Up a Custom Domain</a></li>
    </ul>

    <h2 id="compat">Backward Compatibility</h2>
    <p>ngrok makes promises about the compatibility and stability of its interfaces so that you can
  can confidently build integrations on top and know what changes to expect when upgrading to newer versions.
    </p>
    <h3 id="compat-promise">Compatibility promise</h3>
    <ul>
      <li><strong>Point Release (2.0.0 -&gt; 2.0.1)</strong> - ngrok promises no breaking changes across point releases</li>
      <li><strong>Minor Version Change (2.0 -&gt; 2.1)</strong> - ngrok may make small changes that break
  compatibility for functionality that affects very small minority of users across a minor version change.
      </li>
      <li><strong>Major Version Change (2.0 -&gt; 3.0)</strong> - ngrok makes no promise that any interfaces are stable across a major version change.</li>
    </ul>
    <h3 id="compat-subject">What interfaces are subject to the promise?</h3>
    <ul>
      <li>The ngrok command line interface: the commands and their options</li>
      <li>The ngrok configuration file</li>
      <li>The ngrok agent API</li>
    </ul>
    <p>Anything other interface like the logging format or the web UI is not subject to any compatibility
  promise and may change without warning between versions.
    </p>
    <h3 id="compat-2.3">Changes in 2.3</h3>
    <p>If asked to forward to port 443, ngrok will now automatically forward HTTPS traffic instead of HTTP. This change would
    only affect you if you previously ran a server accepting unencrypted HTTP on port 443. To workaround this, you may specify an explicit http
    URL if you need the old behavior: <code>ngrok http http://localhost:443</code>.
    </p>
    <p>If run under sudo, the ngrok client previously consulted the sudo-ing user's home directory file when looking for its default configuration file.
    It now consults the home directory of the assumed user. To workaround this, you may specify an explicit configuration file location with
    the <code>-config</code> option.
    </p>
    <h3 id="compat-2.2">Changes in 2.2</h3>
    <p>The ngrok agent API no longer accepts <code>application/x-www-form-urlencoded</code> request bodies. In practice, this only affects the <code>/api/requests/http/:id</code> endpoint because posting to the <code>/api/tunnels</code> endpoint with this type of request body previously caused ngrok to crash.</p>
    <p>This change was made to help protect against maliciously crafted web pages that could cause a user to inadvertently interact with their local ngrok API.</p>
    <h3 id="compat-2.1">Changes in 2.1</h3>
    <p>Behavior changes for <code>http</code> and <code>tls</code> tunnels defined in the configuration file or started via the API that do not have
  a <code>subdomain</code> or <code>hostname</code> property.
    </p>
    <div class="well">
      <pre><code>tunnels:
  webapp:
  proto: http
  addr: 80</code></pre>
    </div>
    <p>Given this example tunnel configuration, behavior will change in the following ways.</p>
    <h5>Old Behavior</h5>
    <p>Starts a tunnel using the name of the tunnel as the subdomain resulting in the URL <code>http://webapp.ngrok.io</code></p>
    <h5>New Behavior</h5>
    <p>Starts a tunnel with a random subdomain, for example a URL like <code>http://d95211d2.ngrok.io</code></p>
    <h5>How to keep the old behavior</h5>
    <p>Add a <code>subdomain</code> property with the same name as the tunnel:</p>
    <div class="well">
      <pre><code>tunnels:
  webapp:
  proto: http
  addr: 80
  <strong>subdomain: webapp</strong></code></pre>
    </div>
    <p>This behavior changed in order to make it possible to launch tunnels with random domains. This was preventing the use of the configuration file and agent API to free tier users.</p>

    <h3 id="1.x-sunset">ngrok 1.x sunset</h3>
    <p>The ngrok 1.X service shut down on April 4, 2016. More details can be found on the <a href="/sunset/1">ngrok 1.x sunset announcement</a></p>

    <h2 id="faq">FAQ</h2>
    <h3 id="tunnel-privacy">What information is stored about my tunnels?</h3>
    <p>
      <strong>ngrok does not log or store any data transmitted through your tunneled connections.</strong> ngrok does log some information about the connections which are used for debugging purposes and metrics like the name of the tunnel and the duration of connections. For complete end-to-end security, use a <a href="#tls">TLS tunnel</a>.
    </p>
    <h3 id="name">How do I pronounce ngrok?</h3>
    <p>
      <em>en-grok</em>
    </p>

  </div>
</div>



    

  </body>
  
  
  <script src='/static/js/simulate-typing.js?t=2022-02-06%2017%3A57%3A28.678048' defer></script>
  
  <script src='/static/js/main.js?t=2022-02-06%2017%3A57%3A28.678048' defer></script>
  <script src="/static/js/webflow.js" type="text/javascript" defer></script>

  

</html>
