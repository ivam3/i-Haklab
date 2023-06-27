#ifndef RAINBOW
#define RAINBOW

class rainbow {
public:
  rainbow();
  rainbow(rainbow &&) = default;
  rainbow(const rainbow &) = default;
  rainbow &operator=(rainbow &&) = default;
  rainbow &operator=(const rainbow &) = default;
  ~rainbow();

private:
  
};

rainbow::rainbow() {
}

rainbow::~rainbow() {
}

#endif // !DEBUG
